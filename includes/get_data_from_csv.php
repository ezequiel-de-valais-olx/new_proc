<?php 

class getDataFromCSV
{
	
	public static function csvToArray ($uploaded_file){
		////Inicializacion de variables
			$i =1;
			$csv_headers = array();
			$csv_rows 	 = array();
			$row_data	 =array();
		////

		$uploaded_file = $_FILES["archivo"];

		//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
		if (isset($uploaded_file) && is_uploaded_file($uploaded_file['tmp_name'])) {
		    $input   = $uploaded_file['tmp_name'];
		    echo "Archivo subido correctamente";
			}
			else{
		     echo "Error de subida";
		}

		$csv_data = fopen($input, "r");

		while (!feof($csv_data)){

			$data  = explode(";", fgets($csv_data));

			if ($i <= 1) {
				foreach ($data as $key) {
					array_push($csv_headers, $key);
				}
			}

			if ($i > 1) {
				foreach ($data as $key) {
					array_push($csv_rows, $key);
				}
				if (count($csv_headers)==count($csv_rows)) {
					$row = array_combine($csv_headers, $csv_rows);
					array_push($row_data, $row);	
					$csv_rows = array();
				}
			}
			$i ++;
		}
		return array($csv_headers,$row_data);
	}

	public static function csvToTable($csv_headers,$row_data){
		///imprimir
			$show_tables ="<table>";
			$show_tables .="<thead><tr>";

			foreach ($csv_headers as $key) {
				$show_tables .= "<th>$key </th>\n";
			}

			$show_tables .="</tr>\n<thead>\n<tbody>";

			foreach ($row_data as $key => $line) {
				$show_tables .="\n<tr>";
				foreach ($line as $key => $value) {
					$show_tables .= "<td>$value</td>\n";
				}
				$show_tables .="\n</tr>";
			}

			$show_tables .="</tbody>";
			return $show_tables;
		////
	}

}
?>