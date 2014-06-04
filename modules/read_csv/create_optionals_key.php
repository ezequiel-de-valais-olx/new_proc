<?php

$options = getopt('i:p:c:');
if (!isset($options['i']) or !isset($options['p'] or !isset($options['c'])){
    echo "lo siento falta algo\n";
    echo <<<EOT
\n.
-p: Prefix for output files name. E.g: IssueTicket_country.
-c: Country ID.
-i: Input CSV file with rules with the following format:
========== CSV Format ==========
\tColumn 1:  Parent ID   
\tColumn 2:  Parent name          
\tColumn 3:  Category ID           
\tColumn 4:  Category name
\tColumn 5:  First Level Optional
\tColumn 6:  Second Level Optional
==================================\n\n
EOT;
    die('');
}

$input_file = $options['i'];
$prefix 	= $options['p'];
$country_id = $options['c'];

$data = file($input_file);

$jiraFile   = "${prefix}_jiraTable_output.md";
$csvFile    = "${prefix}_optionalKey_output.csv";

list($csv,$jira,$mensaje)	= optionalKey($data,$country_id);

file_put_contents($csvFile, $csv);
file_put_contents($jiraFile, $jira);

echo $mensaje;

function optionalKey($data, $country){
	$salida_csv	="";
	$salida_jira ="";

	foreach($data as $line) {
		$pattern = array("'é'", "'è'", "'ë'", "'ê'", "'É'", "'È'", "'Ë'", "'Ê'", "'á'", "'à'", "'ä'", "'â'", "'å'", "'Á'", "'À'", "'Ä'", "'Â'", "'Å'", "'ó'", "'ò'", "'ö'", "'ô'", "'Ó'", "'Ò'", "'Ö'", "'Ô'", "'í'", "'ì'", "'ï'", "'î'", "'Í'", "'Ì'", "'Ï'", "'Î'", "'ú'", "'ù'", "'ü'", "'û'", "'Ú'", "'Ù'", "'Ü'", "'Û'", "'ý'", "'ÿ'", "'Ý'", "'ø'", "'Ø'", "'œ'", "'Œ'", "'Æ'", "'ç'", "'Ç'");

		$replace = array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'y', 'y', 'Y', 'o', 'O', 'a', 'A', 'A', 'c', 'C'); 

		$line = str_replace(array(",", ";"), ',',  trim($line))."\n";
		list($parent_id, $parent_name, $category_id, $category_name, $flo, $slo) = explode(',', $line);		
		
		$flo = preg_replace($pattern, $replace, strtolower($flo));
		$slo = preg_replace($pattern, $replace, strtolower($slo));

		if(!is_numeric($parent_id)){
			$salida_csv=$line;
			$salida_jira = "||".$parent_id."||".$parent_name."||".$category_id."||".$category_name."||".$flo."||".trim($slo)."||\n";
			continue;
		}

		if (trim($flo)!="") {
			$flo = str_replace(" ", "-", $flo);
			$flo = str_replace( "-de-", "-", $flo);
			$flo = str_replace( "---", "-", $flo);
			$flo = "opt-".$country."-".$category_id."-".$flo;
		}

		if (trim($slo)!="") {
			$slo = str_replace(" ", "-", $slo);
			$slo = str_replace( "-de-", "-", $slo);
			$slo = str_replace( "---", "-", $slo);
			$slo = $flo."_".$slo;
		}
		
		$salida_csv		.= $parent_id.",".$parent_name.",".$category_id.",".$category_name.",".$flo.",".$slo;
		$salida_jira	.= "|".$parent_id."|".$parent_name."|".$category_id."|".$category_name."|".$flo."|".trim($slo)." |\n";
		$mensaje ="\n==========\ntodo liso\n==========\n";
	}
	return array($salida_csv, $salida_jira,$mensaje);
}