<?php session_start();

$_SESSION["action"] 		= $_POST["action"];

$_SESSION["country"]		= $_POST["country_id"];
$_SESSION["state"] 			= $_POST["state_id"];
$_SESSION["city"]			= $_POST["city_id"];
$_SESSION["neighborhood"] 	= $_POST["neighborhood_name"];
$_SESSION["mail"] 			= $_POST["mail"];
$_SESSION["adType"] 		= $_POST["adtype"];
$_SESSION["quantity"] 		= $_POST["quantity"];
$_SESSION["keyword"] 		= $_POST["keyword"];

$_SESSION["items"] 		= $_POST["items"];

$_SESSION["parent"] 		= $_POST["parent"];
$_SESSION["category"] 		= $_POST["category"];
$_SESSION["flo"]			= $_POST["flo"];
$_SESSION["slo"] 			= $_POST["slo"];

/*
$action = $_POST["action"];

$country 		= $_POST["country_id"];
$state 			= $_POST["state_id"];
$city			= $_POST["city_id"];
$neighborhood 	= $_POST["neighborhood_name"];
$mail 			= $_POST["mail"];
$adType 		= $_POST["quantity"];
$keyword 		= $_POST["action"];

$parent 		= $_POST["action"];
$category 		= $_POST["action"];
$flo 			= $_POST["action"];
$slo 			= $_POST["action"];
*/


/*
////// posting from JSON
	$json =json_decode($_POST["dataToPost"], true);

	if ($action =='form') {		

		$show_tables ="<table>";
		$key_colector 	= array();
		$value_colector = array();


		foreach ($json as $key => $line) {
			foreach ($line as $key => $value) {
				array_push($key_colector, $key);
				array_push($value_colector, $value);
			}
		}

		$show_tables .="<thead><tr>";
		foreach ($key_colector as $key) {
			$show_tables .= "<th>$key </th>\n";
		}


		$show_tables .="</tr>\n<thead>\n<tbody><tr>";


		foreach ($value_colector as $value) {
			$show_tables .= "<td>$value</td>\n";
		}

		$show_tables .="</tr></tbody>";
		$show_tables .="</table>";

		$_SESSION['datos_tabla'] = $show_tables;
	}
/////


///// posting from CSV
/*
	if (isset($_FILES["csv_file"]) && is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
	     $file   = $_FILES['csv_file'];
	     echo "csv_file subido correctamente";
	     echo $csv_file;
	}
	else{
	     echo "Error de subida";
	}

	$csv_file = fopen($file, "r");

	if ($action =='file') {

		define("SEPARATOR", ";");

		foreach($csv_file as $line) {

		    $line = str_replace(array("\r", "\n"), '', $line);

		    list($country, $state, $city, $neighborhood, $parentCategory, $category, $flo, $slo, $adtype, $email, $quantity) = explode(SEPARATOR, $line);

		    if(!is_numeric($country)){
		    	$show_tables .="<tr>";
		    	$show_tables .="<th>$country  <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$state <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$city <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$neighborhood <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$parentCategory <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$category <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$flo <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$slo <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$adtype <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$email <i class='fa fa-sort'></th>";
		    	$show_tables .="<th>$quantity <i class='fa fa-sort'></th>";
		    	$show_tables .="</tr>";
		    }
		    else{
		    	$show_tables .="<tr>";
		    	$show_tables .="<td>$country  <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$state <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$city <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$neighborhood <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$parentCategory <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$category <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$flo <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$slo <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$adtype <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$email <i class='fa fa-sort'></td>";
		    	$show_tables .="<td>$quantity <i class='fa fa-sort'></td>";
		    	$show_tables .="</tr>";
		    }

		}
		$_SESSION['datos_tabla'] = $show_tables;
	}
*/
/////

?>