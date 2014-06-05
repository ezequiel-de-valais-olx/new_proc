<?php 

class GetDataFromCSV
{
	
	public static function csvToArray($file_name){
		$i =1;
		$csv_headers = array();
		$csv_rows 	 = array();
		$row_data	 =array();
		$csv_fd = fopen($file_name, "r");

		while (!feof($csv_fd)){

			$csv_row = str_replace(array('","', ";", '";"','"\t"','"	"'), ',',  strtolower(trim(fgets($csv_fd))));

			$data  = explode(",", $csv_row);

			if ($i == 1) {//te obliga a tener un header
				foreach ($data as $key) {
					$key = strtolower(str_replace(" ", '_',  trim($key)));
					array_push($csv_headers, $key);
				}
			}else{
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

		fclose($csv_fd);
		return array($csv_headers,$row_data);

	}

	public static function csvRead($file){
		$i =1;
		$csv_headers = array();
		$csv_rows 	 = array();
		$row_data	 =array();
		////

		$uploaded_file = $file;

		//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
		if (isset($uploaded_file) && is_uploaded_file($uploaded_file['tmp_name'])) {
		    $input   = $uploaded_file['tmp_name'];
		    echo "Archivo subido correctamente";
			}
			else{
		     echo "Error de subida";
		}

		return $this->csvToArray($input);

	}

	public static function csvToTable($csv_headers,$row_data){
		///imprimir
			$show_tables ="";
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

			$show_tables .="";
			return $show_tables;
		////
	}

	public static function csvRead($file_name){
		$i =1;
		$csv_headers = array();
		$csv_rows 	 = array();
		$row_data	 =array();
		$csv_fd = fopen($file_name, "r");

		while (!feof($csv_fd)){

			$csv_row = str_replace(array('","', ";", '";"','"\t"','"	"'), ',',  strtolower(trim(fgets($csv_fd)))); //porque tiene el \n al final??

			$data  = explode(",", $csv_row);

			if ($i == 1) {//te obliga a tener un header
				foreach ($data as $key) {
					$key = strtolower(str_replace(" ", '_',  trim($key)));
					array_push($csv_headers, $key);
				}
			}else{
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

		fclose($csv_fd);
		return array($csv_headers,$row_data);


	}

}

?>