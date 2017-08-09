<?php
session_start();
if(empty($_SESSION["user"])){
		echo "NoUser";
		exit;
	}
   include_once '../../config.php';
   include_once(ROOT_DIR . '/InputObjects/InputObject.php');
   require 'ImagesTableDataGateway/Images.php';
	//include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();	
	$ImageTableGateWay = new Images();
	$id;
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_GET)) {
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_GET["id"])){ 
			$id = $_GET["id"];
			$_SESSION["id"] = $id;
			$data = $ImageTableGateWay->Find($_GET["id"]);
			//if id is invalid, echo error
		}
		else{
			echo "error";
			exit;
		}
	}
	
	$id = $_SESSION["id"];

if(!empty($id)){
	ini_set('file-uploads',true);
	if($_FILES['userfile']['size']>0)
	{
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];

	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	$fileType = (get_magic_quotes_gpc()==0 
		? mysql_real_escape_string($_FILES['userfile']['type'])
		: mysql_real_escape_string(stripslashes ($_FILES['userfile'])));
		
	$fp       = fopen($tmpName, 'r');
	$content  = fread($fp, filesize($tmpName));
	
	$content  = addslashes($content);

	echo $fileType;
	//echo $content;
	// echo "filename: " . $fileName . "<br />";
	// echo "filesize: " . $fileSize . "<br />";
	// echo "filetype: " . $fileType . "<br />";
	fclose($fp);
	if (! get_magic_quotes_gpc() )
	{
		$fileName = addslashes($fileName);
	}
	try {
		$ImageData = array(
			"image" => $content,
			"name" => $fileName,
			"person_id" => $id,
			"size" =>  $fileSize,
			"type" =>  $fileType
		);
		$existingData = $ImageTableGateWay->Find($_GET["id"]);
		if(empty($existingData)){
		$ImageTableGateWay->insert($ImageData);
		}
		else{
			$ImageTableGateWay->update($ImageData, $existingData["id"]);
		}
		echo "success";
	}
	catch(Exception $e)
	{
		echo "file upload failed: " . mysql_error();
	}
	}
}	
?>
