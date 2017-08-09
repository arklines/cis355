<?php
header("Content-type: image/jpeg");
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
	
if ( !empty($_GET)) {

		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_GET["id"])){ 
			$id = $_GET["id"];
			$_SESSION["id"] = $id;
			$data = $ImageTableGateWay->Find($id);
			echo $data["image"];
			//if id is invalid, echo error
		}
		else{
			echo "error";
			exit;
		}
	}
?>