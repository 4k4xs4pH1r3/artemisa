<?php
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");

$fileTypes = array("pdf");

if (!empty($_FILES)) {

	$tempFile = $_FILES["Filedata"]["tmp_name"];
	$fileName = str_replace($no_permitidas, $permitidas , $_FILES["Filedata"]["name"] );
	$targetPath = "../". $_REQUEST["folder"] . "/";
	$targetFile =  str_replace("//","/",$targetPath) . str_replace($no_permitidas, $permitidas , $_FILES["Filedata"]["name"] );
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileExt']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($fileName);
	$fileParts = pathinfo($_FILES["Filedata"]["name"]);
	if (in_array(strtolower($fileParts["extension"]), $fileTypes)) {
	 //if (in_array(strtolower($fileParts['extension']),$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		mkdir(str_replace("//","/",$targetPath), 0754, true);
		
		move_uploaded_file($tempFile,$targetFile);
		chmod($targetFile,0754);
		echo 1;
	}else{
		echo "Tipo de Archivo Inválido.";
	}
	 /*} else {
	 	echo 'Tipo de Archivo Inválido';
	 }*/
}

?>