<?php
session_start();
if(empty($_SESSION["user"])){
		echo "NoUser";
		//$_SESSION["user"] = "admin";
		exit;
	}
	if(!($_SESSION["user"]=== "admin@svsu.edu") ){
		echo "Unauthorized access";
		exit;
	}
	else{
    include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../PersonsTableDataGateway/Persons.php';
	include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();	
	$PersonTableGateWay = new Persons;
	$columns = $PersonTableGateWay->ReturnColumnsKeyPair();
	$data;
	$errors;
	$status;
	//GET is not allowed on this form
	if ( !empty($_POST)) {
		$Query = $_POST;
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
				if($columnKey === "password_hash"){
					if($Query[$columnKey] === ""){
						$errors[$columnKey] = "value is required";
					}
					else{
					$ValuesAndColumns[$columnKey] =  password_hash($Query[$columnKey], PASSWORD_DEFAULT);
					}
				}
			}
			$data = $ValuesAndColumns;
				//check that data is valid
				$errors = PersonsValidation::CheckEmpty($data);
				//if data isn't empty, validate data
				if(empty($errors)){
					$errors = PersonsValidation::ValidatePerson($data);
				}
			//if data is valid try to insert, return status
			if(empty($errors) || $errors === true){
				$status = "success";
				try{
					$PersonTableGateWay->insert($ValuesAndColumns);
				}	
				catch(Exception $e){
					$status = "error";
					var_dump($e->getMessage());
				}
				$data = null;
				$errors = null;
			}	
    }
	if(!empty($status) && ($status==="success" || $status ==="error")){
		echo $status;
	}
	else{
  
	?>	
		<div id="Personslist">
		<?php
				foreach($columns as $columnkey => $columnValue){
					$isPassword = false;
					$pos = strpos($columnkey, 'pass');
					if(!empty($data)){
					$dataItem = $data[$columnkey];}
					if(!empty($errors)){
					$error = $errors[$columnkey];}
				if (!($pos === false)){
					InputObjects::EchoSecureInputGroup($columnkey, $columnValue, $error);
				}
				else{
					InputObjects::EchoInputGroup($columnkey, $columnValue, $dataItem, $error);
					}
	
			}
				?>
				</div>
		<?php
			}
	}
		?>
