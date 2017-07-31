<?php
    require '../PersonsTableDataGateway/Persons.php';
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
		$pass = $_POST["password_hash"];
		$email = $_POST["email"];
		if(!(empty($pass)) && !(empty($email))){
			$pass = md5($pass);
		 $status = Persons::UserLogin($email, $pass);
		}
		else{
		if(empty($pass) || $pass ===''){
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
