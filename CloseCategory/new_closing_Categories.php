<?php
$shortopt = "i:p:o:";
$longopts = array(
    "countries:"
);
$options = getopt($shortopt, $longopts);

if( !isset($options['i']) || !isset($options['p']) || !isset($options['o']) ){
    echo "Required params were missing.\n";
    show_help();
}


$input_file = $options['i'];
$prefix = $options['p'];
$output_dir = $options['o'];
$sep = ';';


$files = array(
    "close_category" => "{$output_dir}/{$prefix}_close_category.sql",
    "close_items" => "{$output_dir}/{$prefix}_close_items.sql"
);


echo "Generating queries using file $input_file in output directory $output_dir\n";

$categoriesSql = "";
$itemsSql = "";

if (! file_exists($input_file)) {
    echo "Please, provide an existent file.\n\n";
    show_help();
}

$data = file($input_file);
foreach($data as $line) {
	list($action,$country,$parent,$category) = explode($sep, $line);
	$category= trim($category);
	$bothUpdates = strtolower(trim($action)) == "category-items";
	if($bothUpdates || $action == "category"){
        	$categoriesSql  .= "UPDATE geodesic_classifieds_categories_languages SET visible = 0 WHERE category_id = $category and country_id = $country;\n";
	}
	if( trim($parent) != 0 && ($bothUpdates || $action == "items")){
            $itemsSql       .= "SELECT concat('UPDATE olx_items SET live = -4 WHERE id = ', oi.id, ';') as '/* item */' FROM olx_items_$country" . "_$parent oip JOIN olx_items oi ON oip.id = oi.id WHERE oip.category = $category AND oi.live = 1;\n";
	}
}

file_put_contents($files['close_category'], $categoriesSql);
file_put_contents($files['close_items'], $itemsSql);



function show_help(){
    echo "##### SQL Scripts for Closing Categories #####\n";

    echo "-p SQL Prefix Name for Closing Category and Closing Items Category\n";
    echo "Generate queries for new categories.\n";
    echo "-i: Input CSV file with rules with the following format():\n";
    echo "\tcolumn 1: action\n"; 
    echo "\t\t'category': close the category in geodesic_classifieds_categories_languages for the selected country.\n";
    echo "\t\t'items': close items in olx_items for the selected country and category.\n";
    echo "\t\t'category-items': Generate both queries.\n";
    echo "\tcolumn 2: country (country_id)\n";
    echo "\t\tthe category where we should copy the base information.\n";
    echo "\tcolumn 3: parent category id or 0 in case category is a parent\n";
    echo "\tcolumn 4: category id\n";
    echo " \n";

    echo "\t separator: semicolon ';' \n";

    echo "##### How to Run this Script #####\n";
    echo "Including items closure: php closingCategoriesNew.php -i categories.sql -b items.sql -p 185 --countries 10,20 --categories 402,403\n";

    exit();
}
?>
