<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../CoursesTableDataGateway/Courses.php';
	include_once '../CoursesTableDataGateway/CoursesValidation.php';
	session_start();	
	$CourseTableGateWay = new Courses;
	$columns = $CourseTableGateWay->ReturnColumnsKeyPair();

//Check for get and post methods. Prepare to process either one.
if ( !empty($_POST)) {
    if(!empty($_POST["id"])){
        $id = $_POST["id"];
        $data = $CourseTableGateWay->Find($_POST["id"]);
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
elseif(!empty($_GET)) {
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        //check that id is valid
        $data = $CourseTableGateWay->Find($id);
        if (empty($data)) {
            echo "error";
            exit;
        }
    } else {
        echo "error";
        exit;
    }

}
else {
        echo "error";
        exit;
    }
		foreach($columns as $columnkey => $columnValue){
		
			$dataItem = $data[$columnkey];
				InputObjects::EchoReadControlGroup($columnkey, $columnValue, $dataItem);
	
		}
?>




