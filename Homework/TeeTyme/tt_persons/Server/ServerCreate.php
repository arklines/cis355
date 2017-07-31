<?php
session_start();
if(empty($_SESSION["user"])){
		echo "NoUser";
	}
	else{
    require '../PersonsTableDataGateway/Persons.php';
	include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();
	$columns = Persons::ReturnColumnsKeyPair();
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
					$ValuesAndColumns[$columnKey] = md5($Query[$columnKey]);
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
					Persons::insert($ValuesAndColumns);
				}	
				catch(Exception $e){
					$status = "error";
					var_dump($e);
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
		<div id="Personslist">
		<?php
				foreach($columns as $columnkey => $columnValue){
					$isPassword = false;
					$pos = strpos($columnkey, 'pass');
					$dataItem = $data[$columnkey];
					$error = $errors[$columnkey];
				if (!($pos === false)){
					echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
						<label class='control-label'>" . trim($columnValue) . "</label>
						<div class='controls'>
							<input name='" . $columnkey . "' type='password'  placeholder='" . $columnValue . "' value=''>" .
								(!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
						"</div></div>";
				}
				else{
					echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
						<label class='control-label'>" . trim($columnValue) . "</label>
						<div class='controls'>
							<input name='" . $columnkey . "' type='text'  placeholder='" . $columnkey . "' value='" .  (!empty($dataItem)?$dataItem:'') . "'>" .
								(!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
							"</div></div>";
					}
	
			}
				?>
				</div>
		<?php
			}
	}
		?>
