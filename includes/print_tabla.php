
<?php session_start();

include('get_data_from_csv.php');

$uploaded_file = $_FILES["archivo"];

list($csv_headers,$row_data) = getDataFromCSV::csvToArray($uploaded_file);

$tabla = getDataFromCSV::csvToTable($csv_headers,$row_data);

$_SESSION['datos_tabla'] = $tabla;

header('Location: ../tables.php');

/*
include('get_data_from_csv.php');

$uploaded_file = $_FILES["archivo"];

list($csv_headers,$row_data) = getDataFromCSV::csvToArray($uploaded_file);




$for_tabla = array_sort($row_data, 'category', SORT_ASC);

var_dump($for_tabla);
*/
