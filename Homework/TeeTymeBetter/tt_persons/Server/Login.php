<?php
	include_once '../../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
	require '../PersonsTableDataGateway/Persons.php';
	$PersonTableGateWay = new Persons;
	include_once '../PersonsTableDataGateway/PersonsValidation.php';
	session_start();

	$data;
	$pass = "";
	$message;
	$errorp;
	$errorl;
	$email;
	
	//GET is not allowed on this form
	if ( !empty($_POST)){
		if ( !empty($_POST["message"])) {
			$message = $_POST["message"];
			}
		
		$email = $_POST["email"];
		if(!(empty( $_POST["password_hash"])) && !(empty($email))){

		 $status = Persons::UserLogin($email, $_POST["password_hash"]);
		}
		else{
		if(empty( $_POST["password_hash"]) ||  $_POST["password_hash"] ===''){
			$errorp = "Please enter a password";
		}
		if(empty($email) || $email =''){
			$errorl = "Please enter an email";
		}
			
		}
	}	
    
	
	if($status ==="success" || $status==="error"){
		echo $status;
		if($status === "success"){
			$_SESSION["user"] = $email;
		}
	}
	else{
		echo $status;
	?>
		<div id="Personslist">
		<?php
					$dataItem = $email;
      
					echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
						<label class='control-label'>" . "Email" . "</label>
						<div class='controls'>
							<input name='" . "email" . "' type='text'  placeholder='" . "Email" . "' value='" .  (!empty($dataItem)?$dataItem:'') . "'>" .
								(!empty($errorl)?"<span class='help-inline'>" .  $errorl . "</span>" :'') .
							"</div></div>";
							
							echo "<div class='control-group " . (!empty($errorl)?'error':'') . "'>
						<label class='control-label'>" . "Password" . "</label>
						<div class='controls'>
						<input name='" . "password_hash" . "' type='password'  placeholder='" . "Password" . "' value=''>" .
								(!empty($errorp)?"<span class='help-inline'>" .  $errorp . "</span>" :'') .
						"</div>
						</div>";
				?>
			</div>
		<?php
	}
		?>
