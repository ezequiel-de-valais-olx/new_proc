<?php

$help = "Generate queries for redirect categories.\n\n";
$help .= "The CSV file data must be separated whth ';'\n";
$help .= "-i: Input CSV file with rules with the following format:\n";
$help .= "-p: Prefix for output files. E.g: IssueTicket_country.\n";
$help .= "\n========== CSV Format ==========\n";
$help .= "\tColumn 1:  Country_ID          \n";
$help .= "\tColumn 2:  Type                \n";
$help .= "\tColumn 3:  Current URL         \n";
$help .= "\tColumn 4:  Current ID          \n";
$help .= "\tColumn 5:  Type                \n";
$help .= "\tColumn 6:  URL to redirect to  \n";
$help .= "\tColumn 7:  New ID              \n";
$help .= "==================================\n";


$options = getopt('i:p:');
if (!isset($options['i']) or !isset($options['p'])){
    echo $help;
    die('');
}
$input 	= $options['i'];
$prefix = $options['p'];
define("SEPARATOR", ";"); 

$sqlfile    = "${prefix}_urls_redirects.sql";
$sqlfile_rb = "${prefix}_urls_redirects-rollback.sql";
list($sql, $sql_rb) = get_redirects_sql($input);
file_put_contents($sqlfile, $sql);
file_put_contents($sqlfile_rb, $sql_rb);


function get_redirects_sql($input) {
    $sql = "";
    $sql_rb = "";
    $file = fopen($input, "r");

    if ($file) {
        $row = 1;
        while (($data = fgetcsv($file, 1000, SEPARATOR)) !== FALSE) {        
            if ($row != 1) {
                $category_types     = array('subcategory', 'category', 'parent');
                $country_id         = trim($data[0]);
                $from_type          = strtolower(trim($data[1]));
                $from_url           = trim($data[2]);
                $from_category_id   = trim($data[3]);
                $to_type            = strtolower(trim($data[4]));
                $to_url             = trim($data[5]);
                $to_category_id     = trim($data[6]);

                if (in_array($from_type, $category_types)){                   
                        if (in_array($to_type, $category_types)){
                        $sql .= "INSERT INTO olx_listing_redirect (country_id, from_category_id, to_category_id)  VALUES ('$country_id', '$from_category_id', '$to_category_id');\n";
                        $sql_rb .= "DELETE FROM olx_listing_redirect WHERE country_id = '$country_id' AND from_category_id = '$from_category_id' and to_category_id = '$to_category_id';\n";
                    } else if ($to_type == 'optional') {                        
                        $sql .= "INSERT INTO olx_listing_redirect (country_id, from_category_id, to_category_id, to_first_level_slug) VALUES ('$country_id', '$from_category_id', '$to_category_id', '$to_url');\n";
                        $sql_rb .= "DELETE FROM olx_listing_redirect WHERE country_id = '$country_id', from_category_id = '$from_category_id', to_category_id = '$to_category_id', to_first_level_slug = '$to_url';\n";
                    }
                } else if ($from_type == 'optional') {
                    if (in_array($to_type, $category_types)) {
                        $sql .= "INSERT INTO olx_listing_redirect (country_id, from_category_id, to_category_id, from_keywords) VALUES ('$country_id', '$from_category_id', '$to_category_id', '$from_url');\n";
                        $sql_rb .= "DELETE FROM olx_listing_redirect WHERE country_id = '$country_id', from_category_id = '$from_category_id', to_category_id = '$to_category_id', from_keywords = '$from_url';\n";
                    } else if ($to_type == 'optional') {                        
                        $sql .= "INSERT INTO olx_listing_redirect (country_id, from_category_id, to_category_id, to_first_level_slug) VALUES ('$country_id', '$from_category_id', '$to_category_id', '$to_url');\n";
                        $sql_rb .= "DELETE FROM olx_listing_redirect WHERE country_id = '$country_id', from_category_id = '$from_category_id', to_category_id = '$to_category_id', to_first_level_slug = '$to_url';\n";
                    }
                }
            }
            $row ++;
        }
    }
    return array($sql, $sql_rb);
} 
?>
