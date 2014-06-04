<?php
session_start();
/* aca van los argumentos
$country_id = 30; //Brasil
$state_id = 6854; // Sao Paulo
$city_id = 53695; // Sao Paulo
$parent_id = 815; //moda
$category_id = 817; // ropa calzado

*/
switch($_POST['action']) {
    case 'country':
            $returnData = getCountries();
            return $returnData;
        break;
    case 'states':
            $returnData = getStates($_POST['id']);
            return $returnData;
        break;

    case 'cities':
            $returnData = getCities($_POST['id']);
            return $returnData;
        break;
    case 'neighborhoods':
            $returnData = getNeighborhoods($_POST['id']);
            return $returnData;
        break;
    case 'parents':
            $returnData = getParents($_POST['id']);
            return $returnData;
        break;
    case 'categories':
            $returnData = getCategories($_POST['id'],$_POST['country_id']);
            return $returnData;
        break;
    case 'flo':
            $returnData = getFlo($_POST['id'],$_POST['country_id']);
            return $returnData;
        break;
    case 'slo':
            $returnData = getSlo($_POST['id']);
            return $returnData;
        break;
}

//Get States

/*
foreach ($states as $array) {
    echo $array['id']."\t";
    echo $array['name']."\n"; 
}

//Get Cities
$cities = getCities($state_id);
echo "\n";
foreach ($cities as $array) {

    echo $array['id']."\t";
    echo $array['name']."\n"; 
}

//Get Neighborhood
$neighborhoods = getNeighborhood($city_id);
echo "\n";
foreach ($neighborhoods as $array) {

    echo $array['name']."\n"; 
}


//get FLO
$country_id = 30;
$category_id = 805; // ropa calzado
$flo = 'opt-366-audiovideo';

$flo2 = getFlo($category_id,$country_id);
foreach ($flo2 as $array) {

    echo $array['value']."\t";
    echo $array['message']."\n"; 
}



//get SLO
$slo = getSlo($flo,$category_id,$country_id);
echo "\n";
foreach ($slo as $array) {

    echo $array['value']."\t";
    echo $array['message']."\n"; 
}


*/
function dev_connect(){
    $db_database = "DBOLX_1";
    $db_hostname = "db1-dev.olx.com.ar";
    $db_username = "dev_core";
    $db_password = "+qyvpis6l#";

    $link = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_select_db($db_database);
    return $link;
}

function models_connect(){
    $db_database = "MODELS_CATALOG";
    $db_hostname = "db1-dev.olx.com.ar";
    $db_username = "dev_core";
    $db_password = "+qyvpis6l#";

    $link = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_select_db($db_database);
    return $link;
}

function catspec_connect(){
    $db_database = "DBOLX_CATSPEC";
    $db_hostname = "db1-dev.olx.com.ar";
    $db_username = "dev_core";
    $db_password = "+qyvpis6l#";

    $link = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_select_db($db_database);
    return $link;    
}

function translation_connect(){
    $db_database = "DBOLX_TRANSLATIONS";
    $db_hostname = "192.168.100.240";
    $db_username = "dev";
    $db_password = "+v8xDh4a7#";

    $link = mysql_connect($db_hostname, $db_username, $db_password);
    mysql_select_db($db_database);
    return $link;    
}

function getCountries(){
    $link = dev_connect();
    $query = "SELECT country_id, name FROM geodesic_countries;";
    $result = mysql_query($query);


    while($row = mysql_fetch_array($result)){
        $country[]=array("id"=>$row[0],"name"=>$row[1]);
            
    }
 
    mysql_close($link);
 
    return $country;
}

function getStates($country_id){
    $link = dev_connect();
    $query = "SELECT state_id, name FROM geodesic_states WHERE country_id = $country_id;";
    $result = mysql_query($query);


    while($row = mysql_fetch_array($result)){
        $state[]=array("id"=>$row[0],"name"=>$row[1]);
            
    }
 
    mysql_close($link);
 
    return $state;
}

function getCities($state_id){
    $link = dev_connect();
    $query = "SELECT city_id, city_name FROM olx_cities WHERE state_id = $state_id;";
    $result = mysql_query($query);
 
    while($row = mysql_fetch_array($result)){
        $city[] = array("id"=>$row[0],"name"=>$row[1]);
    }
 
    mysql_close($link);
 
    return $city;

}

function getNeighborhoods($city_id){
    $link = dev_connect();
    $query = "SELECT unified_id FROM olx_cities WHERE city_id = $city_id";
    $result = mysql_query($query);
    $row = mysql_fetch_row($result);
    $unified_id = $row[0];
    mysql_close($link);

    $link = models_connect();
    $query = "SELECT name FROM location WHERE parent_id = $unified_id;";
    $result = mysql_query($query);

    while($row = mysql_fetch_array($result)){
        $neighborhood[] = array("name"=>$row[0]);
    }

    mysql_close($link);

    return $neighborhood;
}

function getParents($country_id){
    $link = dev_connect();
    $query = "SELECT category_id, category_name FROM geodesic_categories WHERE parent_id = 0 AND category_id IN (SELECT category_id FROM geodesic_classifieds_categories_languages WHERE country_id = $country_id AND visible = 1);";
    $result = mysql_query($query);

    while($row = mysql_fetch_array($result)){
        $parent[] = array("id"=>$row[0],"name"=>$row[1]);
    }
 
    mysql_close($link);

    return $parent;
}

function getCategories($parent_id, $country_id){
    $link = dev_connect();
    $query = "SELECT category_id, category_name FROM geodesic_categories WHERE parent_id = $parent_id AND category_id in (SELECT category_id FROM geodesic_classifieds_categories_languages WHERE country_id = $country_id and visible = 1);";
    $result = mysql_query($query);

    while($row = mysql_fetch_array($result)){
        $category[] = array("id"=>$row[0], "name"=>$row[1]);
    }
    mysql_close($link);

    return $category;
}

function getFlo($category_id, $country_id){
    $link = catspec_connect();
    $query = "SELECT value, id FROM olx_catspec_possible_value WHERE dataset_id in (SELECT dataset_id FROM olx_catspec_applicable_field WHERE country_id = $country_id AND category_id = $category_id and field_id = 53);";
    $result = mysql_query($query);

    while($row = mysql_fetch_array($result)){
        $value[] = array("value"=>$row[0], "id" => $row[1]);
    }
    mysql_close($link);

/*

    $link = translation_connect();
    
    if($value[0]['value'] != NULL){

        foreach ($value as $array) {
            $key = $array['value'];
            $id = $array['id'];
            $query = "SELECT Translation FROM MessageLang WHERE MessageKey = '$key' AND LangId = 1;";
            $result= mysql_query($query);
            $row = mysql_fetch_row($result);
            $message[] =array("id" => $id, "value"=>$key, "message"=>$row[0]);
        }
    }
    
    mysql_close($link);
*/  
    return($value);
}

function getSlo($flo_id){
    $link = catspec_connect();
    $query = "SELECT value, id FROM olx_catspec_possible_value WHERE parent_id = $flo_id;";
    $result = mysql_query($query);

    while($row = mysql_fetch_array($result)){
        $value[] = array("value"=>$row[0],"id" => $row[1]);
    }
    mysql_close($link);

/*
    $link = translation_connect();
    if($value[0]['value'] != NULL){
        foreach ($value as $array) {
            $key = $array['value'];
            $id = $array['id'];
            $query = "SELECT Translation FROM MessageLang WHERE MessageKey = '$key' AND LangId = 1;";
            $result= mysql_query($query);
            $row = mysql_fetch_row($result);
            $message[] =array("id" => $id, "value"=>$key, "message"=>$row[0]);
        }
    }
    mysql_close($link);
*/    
    return($value);
}
