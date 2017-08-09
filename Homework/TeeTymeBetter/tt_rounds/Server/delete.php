<?php
session_start();
	if(empty($_SESSION["user"])){
		echo "NoUser";
		exit;
	}
	if(!($_SESSION["user"]=== "admin@svsu.edu") ){
		echo "Unauthorized access";
		exit;
	}
	include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../RoundsTableDataGateway/Rounds.php';
	include_once '../RoundsTableDataGateway/RoundsValidation.php';
	session_start();
	
	$RoundsTable = new Rounds;
	$columns = $RoundsTable->ReturnColumnsKeyPair();
	$id;
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_POST["id"])){ 
			$id = $_POST["id"];
			$data = $RoundsTable->Find($_POST["id"]);
			//if id is invalid, echo error
			if(empty($data)){
				echo "error";
				exit;
			}
		}
		else{
		echo "error";
		exit;
		}
	}
	elseif(!empty($_GET)){
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_GET["id"])){	
			$id = $_GET["id"];
			//check that id is valid
			$data = $RoundsTable->Find($id);
			if(empty($data)){
				echo "error";
				exit;
			}
		}
		else{
		echo "error";
		exit;
		}
	}
	else{
		echo "error";
		exit;
	}
	if(!empty($_GET['status'])){
		$confirm = $_GET['status'];
		if ( !empty($id) && !empty($confirm)) {
		Rounds::Delete($id);
			echo "success";
			exit;
		}
		else{echo "error";}
	}
	else{
	$confirm = false;
	echo "Are you sure you wish to delete this Round? Any member playing will be unable to continue.";
	}
	
	?>			
		