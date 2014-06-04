<?php

class generateRedirect
{
    public static function getRedirectsSql($input) {
        ////Inicializacion de variables
            $sql = "";
            $sql_rb = "";
            $separador = ","; 
        ////

        if (($file = fopen($input, "r")) !== FALSE) {
            $row = 1;
            while (($data = fgetcsv($file, 1000, $separador)) !== FALSE) {        
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
}