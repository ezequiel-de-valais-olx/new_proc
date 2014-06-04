<?php session_start();

include('get_data_from_csv.php');

$uploaded_file = $_FILES["archivo"];

list($csv_headers,$row_data) = getDataFromCSV::csvToArray($uploaded_file);

$tabla = getDataFromCSV::csvToTable($csv_headers,$row_data);

$_SESSION['datos_tabla'] = $tabla;


$input_file = $uploaded_file;
//$output_dir = $_GET['output'];
$prefix 	= $_GET['prefix'];
$country_id = $_GET['country'];
$sep 		= ';';


if (isset($_FILES["archivo"])) {
	echo "\nprefijo = ".$prefix;
	echo "\npais = ".$country_id;
	echo "\nseparador = ".$sep;
}

$files = array(
    "cleanup" => "{$prefix}_initial_delete.sql",
    "ddl" => "{$prefix}_items_tables.sql", 
    "dml" => "{$prefix}_create_categories.sql", 
    "filter" => "{$prefix}_filter-category-generator.sql", 
    "rollback1" => "{$prefix}_rollback1.sql", 
    "rollback2" => "{$prefix}_rollback2.sql",
);

//echo "Generating queries using file $input_file in output directory $output_dir\n";

if ($initial_delete) {
    initial_delete($files, $country_id);
}
$data = $input_file;

foreach($data as $line) {
    $line = str_replace(array("\r", "\n"), '', trim($line));
    list($action, $base_category, $parent_id, $category_id, $language_id, 
        $category_name, $category_slug) = explode($sep, $line);

    if (trim($action) == "action") continue;

    $category_name = addslashes(trim($category_name));
    $category_slug = addslashes(trim($category_slug));
    if (empty($category_slug)) {
        $category_slug = $category_name;
    }
    if (empty($base_country)) {
        $base_country = $country_id;
    }

    create_category(
        $files, $country_id, $action, $base_category, $parent_id, $category_id, 
        $language_id, $category_name, $category_slug, $base_country
    );
}

function create_category($files, $country_id, $action, $base_category, 
                         $parent_id, $category_id, $language_id, 
                         $category_name, $category_slug, $base_country)
{
    $actions = array('new', 'language', 'use');
    if (! in_array($action, $actions)) {
        return;
    }
    $is_new = $action == $actions[0];
    $just_language = $action == $actions[1];

    write_comment(
        $files, $country_id, $parent_id, $category_id, $category_name, 
        $language_id
    );
    if (! $just_language) {
        if ($is_new) {
            create_geodesic_categories(
                $files, $parent_id, $category_id, $category_name
            );
        }
        create_country_category($files, $country_id, $category_id);

        if ($parent_id == 0) {
            create_items_table(
                $files, $country_id, $category_id, $base_category, 
                $base_country
            );
            create_listing_filters($files, $country_id, $category_id);
            if($is_new) {
                create_generators_filter_category(
                    $files, $category_id, $base_category
                );
            }

        }
    }

    create_categories_languages(
        $files, $language_id, $country_id, 
        $category_id, $category_name, $category_slug
    );

    write_to_all($files, "\n");
}

function write_comment($files, $country_id, $parent_id, $category_id, 
                       $name, $language_id)
{
    $comment  = "Country: $country_id, Parent: $parent_id, ";
    $comment .= "Category: $category_id, Name: $name, Language: $language_id";
    if ($parent_id == 0) {
        $comment = '/* ' . $comment . ' */';
    } else {
        $comment = '-- ' . $comment;
    }
    $comment .= "\n";
    write_to_all($files, $comment);
    echo "$comment\n";
}

function write_to_all($files, $line)
{
    foreach ($files as $file) {
        file_put_contents($file, $line, FILE_APPEND);
    }
}

function initial_delete($files, $country_id) 
{
    $sql = "DELETE FROM olx_country_category WHERE country_id={$country_id};\n";
    $sql .= "DELETE FROM geodesic_classifieds_categories_languages WHERE country_id={$country_id};\n";
    file_put_contents($files['cleanup'], $sql, FILE_APPEND);
}


function create_items_table($files, $country_id, $category_id, $base_category,
                            $base_country)
{

    $table = "olx_items_{$country_id}_{$category_id}";
    $table_wikilink = "olx_items_wikilink_{$country_id}_{$category_id}";
    $sql  = "CREATE TABLE $table LIKE olx_items_{$base_country}_{$base_category};\n";
    $sql .= "CREATE TABLE $table_wikilink LIKE olx_items_wikilink_{$base_country}_{$base_category};\n";
    file_put_contents($files['ddl'], $sql, FILE_APPEND);

    $rollback  = "DROP TABLE IF EXISTS $table;\n";
    $rollback .= "DROP TABLE IF EXISTS $table_wikilink;\n";
    file_put_contents($files['rollback1'], $rollback, FILE_APPEND);
}

function create_geodesic_categories($files, $parent_id, $id, $name)
{
    $sql = "INSERT INTO geodesic_categories (category_id, parent_id, category_name, use_site_default, display_photo_icon, use_zip_field, use_city_field, use_state_field, use_country_field, display_entry_date, use_optional_field_2, display_ad_title, display_order, display_price, category_image, in_statement) VALUES ($id, $parent_id, '$name', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1000, 1, 0, '');\n";
    file_put_contents($files['dml'], $sql, FILE_APPEND);
    $rollback_last = "DELETE FROM geodesic_categories WHERE category_id = $id;\n";
    file_put_contents($files['rollback2'], $rollback_last, FILE_APPEND);
}

function create_country_category($files, $country_id, $category_id)
{
    $sql = "INSERT INTO olx_country_category (country_id, category_id, itempage_map_enabled, posting_map_enabled, listingpage_map_enabled, `order`, ad_blocking_policy, comment_policy, use_comment_review, display_year, display_mileage) VALUES ({$country_id}, {$category_id}, 0, 1, 0, 1000, 0, 0, 1, 0, 0);\n";
    file_put_contents($files['dml'], $sql, FILE_APPEND);
    $rollback = "DELETE FROM olx_country_category WHERE country_id = {$country_id} AND category_id = {$category_id};\n";
    file_put_contents($files['rollback1'], $rollback, FILE_APPEND);
}

function create_listing_filters($files, $country_id, $category_id)
{
    $sql = "INSERT INTO olx_listing_candidatefilters (id_filter,parent_category,country,category,data_domain_id) VALUES (7,$category_id,$country_id,NULL,1);\n";
    file_put_contents($files['dml'], $sql, FILE_APPEND);
    $rollback = "DELETE FROM olx_listing_candidatefilters WHERE id_filter=7 AND parent_category={$category_id} AND country={$country_id} AND category IS NULL AND data_domain_id=1;\n";
    file_put_contents($files['rollback1'], $rollback, FILE_APPEND);
}

function create_generators_filter_category($files, $category_id, $base_category)
{
    $sql = "SELECT CONCAT(\"INSERT INTO olx_filter_category (filter_id, category_id) VALUES (\", filter_id, \", $category_id);\") as '/* $category_id */' FROM olx_filter_category WHERE category_id = $base_category;\n";
    file_put_contents($files['filter'], $sql, FILE_APPEND);
}

function create_categories_languages($files, $lang_id, $country_id,     
                                     $category_id, $name, $textlink)
{
    $sql = "INSERT INTO geodesic_classifieds_categories_languages (category_id, country_id, category_name, category_textlink, language_id, visible, category_cache, newest_category_cache, featured_pic_category_cache, featured_text_category_cache, seller_category_cache) VALUES ({$category_id}, {$country_id}, '{$name}', '{$textlink}', {$lang_id}, 1, '', '', '', '', '');\n" ;
    file_put_contents($files['dml'], $sql, FILE_APPEND);

    $rollback = "DELETE FROM geodesic_classifieds_categories_languages WHERE category_id = {$category_id} AND country_id = {$country_id} AND language_id = {$lang_id};\n";
    file_put_contents($files['rollback1'], $rollback, FILE_APPEND);
}


echo $tabla;
//header('Location: ../tables.php');

/*
include('get_data_from_csv.php');

$uploaded_file = $_FILES["archivo"];

list($csv_headers,$row_data) = getDataFromCSV::csvToArray($uploaded_file);




$for_tabla = array_sort($row_data, 'category', SORT_ASC);

var_dump($for_tabla);
*/
