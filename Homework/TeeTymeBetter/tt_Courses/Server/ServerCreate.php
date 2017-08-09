<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
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
    require '../CoursesTableDataGateway/Courses.php';
	include_once '../CoursesTableDataGateway/CoursesValidation.php';
	session_start();	
	$CourseTableGateWay = new Courses;
	$columns = $CourseTableGateWay->ReturnColumnsKeyPair();
	
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
		$Query = $_POST;
	}
	elseif(!empty($_GET)){
		$Query = $_GET;
	}
	//post will not be considered empty if the create button on create.html was clicked,
	//even if there is no data in post. This is why post must be validated.
	
	if ( !empty($Query)) {
		// if there is nothing in post, just continue to html as normal
			//if there are no errors, prepare to insert data
			$Errors = array();
			$ValuesAndColumns = array();
			foreach($columns as $columnKey => $columnText){
				$ValuesAndColumns[$columnKey] = $Query[$columnKey];
			}
				$data = $ValuesAndColumns;
				//check that data is valid
				$errors = CoursesValidation::CheckEmpty($data);
				//if data isn't empty, validate data
				if(empty($errors)){
					$errors1 = CoursesValidation::ValidateCourse($data);
					$errors2 = CoursesValidation::ValidateNumerics($data);
					$errors = array_merge($errors1, $errors2);
				}
			//if data is valid try to insert, return status
			if(empty($errors) || $errors === true){
				$status = "success";
				try{
					$CourseTableGateWay->insert($data);
				}	
				catch(Exception $e){
					$status = "error";
				}
				$data = null;
				$errors = null;
			}	
    }
    if($status==="success" || $status ==="error"){
		echo $status;
	}
	else{
	?>			
		<div id="Courselist">
		<?php
				foreach($columns as $columnkey => $columnValue){	
				$dataItem = $data[$columnkey];
				$error = $errors[$columnkey];
				InputObjects::EchoInputGroup($columnkey, $columnValue, $dataItem, $error);
				}
				?>
				</div>
		<?php
			}
		?>




