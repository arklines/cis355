<?php
session_start();
	if(empty($_SESSION["user"])){
		echo "NoUser";
		exit;
	}
    require '../CoursesTableDataGateway/Courses.php';
	include_once '../CoursesTableDataGateway/CoursesValidation.php';
	session_start();
	
	$columns = Courses::ReturnColumnsKeyPair();
	$id;
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_POST["id"])){ 
			$id = $_POST["id"];
			$data = Courses::Find($_POST["id"]);
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
			$data = Courses::Find($id);
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
		Courses::Delete($id);
			echo "success";
			exit;
		}
		else{echo "error";}
	}
	else{
	$confirm = false;
	echo "Are you sure you wish to delete this course? Any rounds on this course for today will be removed.";
	}
	
	?>			
		