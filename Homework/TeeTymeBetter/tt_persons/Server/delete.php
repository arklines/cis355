<?php
session_start();
if(empty($_SESSION["user"])){
		echo "NoUser";
		exit;
	}

    include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../PersonsTableDataGateway/Persons.php';
	include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();	
	$PersonTableGateWay = new Persons;
	$id;
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_POST["id"])){ 
			$id = $_POST["id"];
			$data = $PersonTableGateWay->Find($_POST["id"]);
			var_dump($data);
			if($data["email"]=== "admin@svsu.edu"){
				echo "you cannot delete the admin account";
				exit;
			}
		if(!($_SESSION["user"]=== $data["email"]) && !($_SESSION["user"]=== "admin@svsu.edu")){
				echo "Unauthorized access";
				exit;
				}
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
			$data = $PersonTableGateWay->Find($id);
			if($data["email"]=== "admin@svsu.edu"){
				echo "you cannot delete the admin account";
				exit;
			}
		if(!($_SESSION["user"]=== $data["email"]) && !($_SESSION["user"]=== "admin@svsu.edu")){
				echo "Unauthorized access";
				exit;
				}
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
		$PersonTableGateWay->Delete($id);
			echo "success";
			if($_SESSION["user"]=== $data["email"]){
				unset($_SESSION["user"]);
			}
			exit;
		}
		else{echo "error";}
	}
	else{
	$confirm = false;
	echo "Are you sure you wish to delete this person? Any rounds scheudled for today with this person will be removed.";
	}

	?>			
		