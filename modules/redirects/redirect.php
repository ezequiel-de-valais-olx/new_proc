<?php
include 'generateRedirect.php';
include '../read_csv/get_data_from_csv.php';

/*
	if (!isset($options['i']) or !isset($options['p'])){
	    echo <<<EOT
	Generate queries for redirect categories.\n
	The CSV file data must be separated whth ';'
	-i: Input CSV file with rules with the following format:
	-p: Prefix for output files. E.g: IssueTicket_country.
	\n========== CSV Format ==========
	\tColumn 1:  Country_ID          
	\tColumn 2:  Type                
	\tColumn 3:  Current URL         
	\tColumn 4:  Current ID          
	\tColumn 5:  Type                
	\tColumn 6:  URL to redirect to  
	\tColumn 7:  New ID              
	==================================
	EOT;
	    die('');
	}
*/

$input 	= $_FILES['inputCsv'];
$prefix = $_POST['prefix'];

$file = fopen($input, "r");
$data = fgetcsv($file, 1000, ',');

var_dump($data);

//var_dump(getDataFromCSV::csvToArray($input));

/*
$sqlfile    = "${prefix}_urls_redirects.sql";
$sqlfile_rb = "${prefix}_urls_redirects-rollback.sql";

list($sql, $sql_rb) = generateRedirect::getRedirectsSql($input);

file_put_contents($sqlfile, $sql);
file_put_contents($sqlfile_rb, $sql_rb);
*/