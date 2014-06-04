<?php

//$options = getopt('f:q:t:');
//$filename = isset($options['f']) ? $options['f'] : 'ads-jobs.csv';
//$qty = isset($options['q']) ? $options['q'] : 50;

$post_params['generator'] = ['csv' or 'form'];
$post_params['country'] = [country_id];
$post_params['state'] = [state_id];
$post_params['city'] = [city_id];
$post_params['neighborhood'] = [neighborhood_name];
$post_params['multiple_postings'] = [cat_post];
$post_params['mail'] = [mail];
$post_params['posting'][] = array("parent"=>[parent_id], "category" => [category_id], "flo" => [flo_name."_".flo_id],"slo" => [slo_name."_".slo_id]);
$post_params['csv'] = [filename];


$timeout = 30;

$nro  = 1;
$country = $_POST['country'];
$state = $_POST['state'];
$city = $_POST[̈́'city'];
$neighborhood = $_POST['neighborhood'];
$mail = $_POST['mail'];
$qty = $_POST['multiple_postings'];


if($_POST['generator'] == 'csv'){
    if( $_FILES['file']['error'] == 0 ){
        $filename = "/tmp/".$_FILES['file']['name'];
        copy( $_FILES['file']['tmp_name'], $filename ) or 
               die( "Could not copy file!");      
    }else{
        die("No file specified!");
    }
    csv_check($filename);
    $data = file($filename);

    foreach($data as $line)
    {
        list($parent, $category, $flo, $slo, $ad_type, $keywords) = explode(',', $line);
        
        if ($flo == "*") $flo = "";
        if ($slo == "*") $slo = "";
        if ($ad_type == "*") $ad_type = "0";

        
        $title = "Titulo del posting $parent > $category: $nro";

        for ($i=1; $i<=$qty; $i++)
        {
            $description = "Descripcion del posting en $parent > $category, ad_type: $ad_type / $nro($i)<br />";
            $description.= "Opcionales: $flo - $slo / Keywords: $keywords -- " . md5(time());

            $post_params = getPostParams($state, $city, $neighborhood, $country, $parent, $category, $flo, $slo, $keywords, $ad_type, "$title $i", $description, $mail);
            $url_posting = 'www.olx.com/ajax/posting_in_one_step_ajax.php';

            $handler = curl_init($url_posting);

            curl_setopt($handler, CURLOPT_POST, true);
            curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($post_params));
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handler, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, $timeout * 1000);
            curl_setopt($handler, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($handler, CURLOPT_TIMEOUT, $timeout);
            $response = curl_exec($handler);
            curl_close($handler);
            //echo ("ROW $nro($i) - catg:$parent-$category: $response" . PHP_EOL);
        }
        ++ $nro;
    }
}
else if($_POST['generator' == 'form']){
        foreach($_POST['posting'] as $line)
    {
        $parent = $line['parent'];
        $category = $line['category'];
        $flo = $line['flo'];
        $slo = $line['slo'];
        $ad_type = $line['ad_type'];
        $keywords = $line['keywords'];
        
        if ($flo == "*") $flo = "";
        if ($slo == "*") $slo = "";
        if ($ad_type == "*") $ad_type = "0";

        $title = "Titulo del posting $parent > $category: $nro";

        for ($i=1; $i<=$qty; $i++)
        {
            $description = "Descripcion del posting en $parent > $category, ad_type: $ad_type / $nro($i)<br />";
            $description.= "Opcionales: $flo - $slo / Keywords: $keywords -- " . md5(time());

            $post_params = getPostParams($state, $city, $neighborhood, $country, $parent, $category, $flo, $slo, $keywords, $ad_type, "$title $i", $description, $mail);
            $url_posting = 'www.olx.com/ajax/posting_in_one_step_ajax.php';

            $handler = curl_init($url_posting);

            curl_setopt($handler, CURLOPT_POST, true);
            curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($post_params));
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handler, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, $timeout * 1000);
            curl_setopt($handler, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($handler, CURLOPT_TIMEOUT, $timeout);
            $response = curl_exec($handler);
            curl_close($handler);
            //echo ("ROW $nro($i) - catg:$parent-$category: $response" . PHP_EOL);
        }
        ++ $nro;
    }

}


function getPostParams($state, $city, $neighborhood,$country, $parent, $category, $flo, $slo, $keywords, $ad_type, $title, $description, $mail)
{
    $post_params['action'] = 'post';
    $post_params['formHash'] = '4e15292666ab5928065d9bf60e034d05';
    $post_params['categoryID'] = $category;
    $post_params['countryID'] = $country;
    $post_params['set_country_filter'] = $country;
    $post_params['sessionHash'] = '4806422';
    $post_params['categoryChild'] = $category;
    $post_params['categoryParent'] = $parent;
    $post_params['optionals']['OptionalOne'] = trim($flo);
    $post_params['optionals']['OptionalOneOther'] = '';
    $post_params['optionals']['OptionalTwo'] = trim($slo);
    $post_params['optionals']['OptionalTwoOther'] = '';
    $post_params['listing_type'] = 2;
    $post_params['classified_type'] = $ad_type;
    $post_params['ad_type'] = $ad_type;
    $post_params['_classifiedType'] = 0;
    $post_params['title'] = $title;
    $post_params['max_orderAux'] = 1;
    $post_params['imageQty'] = 0;
    $post_params['sell_session'] = 13557597390496385031059;
    $post_params['description'] = $description;
    $post_params['currency_typeC'] = 30;
    $post_params['C'] = '1.024,00';
    $post_params['priceC'] = 4343434;
    $post_params['ad_language_id'] = 1;
    $post_params['priority'] = '';
    $post_params['identity'] = 1;
    $post_params['contact-name'] = 'SoyUnBot';
    $post_params['email'] = $mail;
    $post_params['phone'] = '';
    $post_params['state'] = $state;
    $post_params['city'] = $city;
    $post_params['neighborhood_name'] = $neighborhood;
    $post_params['countryStateCityCase'] = 1;
    $post_params['usesAutoComplete'] = '';
    $post_params['useNeighborhoodMultiSelector'] = '';
    $post_params['streetaddress'] = '';
    $post_params['addresslat'] = '';
    $post_params['addresslng'] = '';
    $post_params['relTypes'] = '';
    $post_params['sk'] = '|||';

    return $post_params;
}


function csv_check($filename){
    
    $data = file($filename);
    $newfile = "/tmp/aux.csv";
    $data_aux = fopen($newfile, 'w');

    foreach ($data as $line) {
        list($parent, $category, $flo, $slo, $ad_type, $keywords) = explode(',', $line);
        if($parent != 'parent'){
            if ($flo == "*") $flo = "";
            if ($slo == "*") $slo = "";
            if ($flo == "-") $flo = "";
            if ($slo == "-") $slo = "";

            if($flo != ""){
                $floOk =explode($flo, '_');   
                if($floOk[0] == '_' ){

                    $query = "SELECT id FROM olx_catspec_possible_value WHERE dataset_id in (SELECT dataset_id FROM olx_catspec_applicable_field WHERE country_id = $country_id and category_id = $category) AND value = '$flo';";

                    $result = mysql_query($query);
                    $row = mysql_fetch_row($result);
                    $flo = $flo.'_'.$row[0];
                }
            }

            if($slo != ""){
                $sloOk =explode($slo, '_');   
                if($sloOk[0] == '_' ){

                    $query = "SELECT id FROM olx_catspec_possible_value WHERE dataset_id in (SELECT dataset_id FROM olx_catspec_applicable_field WHERE country_id = $country_id and category_id = $category) AND value = '$slo';";

                    $result = mysql_query($query);
                    $row = mysql_fetch_row($result);
                    $slo = $slo.'_'.$row[0];
                }
            }
            $str_row = "$parent, $category, $flo, $slo, $ad_type, $keywords";
            fwrite($data_aux, $str_row);
        }
    }
        fclose($data_aux);
        mysql_close($link);

        $data = file($newfile);
        $data_aux = fopen($filename, 'w');

        foreach ($data as $line) {
            fwrite($data_aux, $line);
        }
        fclose($data_aux);
        unlink($newfile);
}

?>