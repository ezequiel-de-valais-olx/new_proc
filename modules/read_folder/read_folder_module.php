<?php

$DirectoryPath = "csv_files_to_read/";

$lastModification = filemtime($DirectoryPath);

$recivedTime = 1401772376;#$_GET['lastAccess'];

/*/echos
	echo"<b>fecha recivida: " . $recivedTime . "<br/><br/>";
	echo"<b>$DirectoryPath <br>was last modified: " . filemtime($DirectoryPath) . "<br/><br/>";
	echo"<b>Nombre del Directorio:</b> $dir<br>";
//----/*/


if ($recivedTime<=$lastModification) {
	$respuesta = "<h2 style='color:red;'>no hubo modificaciones</h1>";
	//echo $respuesta;

	return $respuesta;

} else {

	list($foldersContent, $mensage) = readFolder($DirectoryPath);

	//return $mensage;
	echo $mensage;
	//var_dump($foldersContent);
	//var_dump(json_encode($foldersContent));
}


function readFolder($DirectoryPath){
	$dir = $DirectoryPath;
	$foldersContent = array();
	$mensage = "";

	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			if (is_dir_empty($dir)) {
				$mensage .= "la carpeta esta vacia";
			}else{
				while (($file = readdir($dh))) {
					$path =$dir.$file;
					$toPush = array('name' => $file,'path' => $path, 'type' => filetype($path), 'lastMod' => date("F d Y H:i:s.", filectime($path)));				
					if (is_dir($path)) {
						if ($file == '.' or $file == '..') continue;
						array_push($foldersContent, $toPush);
						$mensage .= "<br/><b>esto es una carpeta:</b> $file <br />\n";
						$mensage .= "<b>link al archivo:</b> <a href='" . $path . "'>".$path . "</a><br/>\n";
					} else {
						if ($file == '.' or $file == '..') continue;
						array_push($foldersContent, $toPush);					
						$mensage .= "<br/><b>nombre del archivo:</b> $file\n";
						$mensage .= "<br/><b>tipo de archivo:</b> " . filetype($path) . "<br/>\n";
						$mensage .= "<b>link al archivo:</b> <a href='" . $path . "'>".$path . "</a><br/>\n";
					}	
				}
			}
			closedir($dh);
		}
	}
	return  array($foldersContent, $mensage);
}

function is_dir_empty($dir) {
	if (!is_readable($dir)) return NULL; 
	return (count(scandir($dir)) == 2);
}