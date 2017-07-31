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
	$id;
	$data;
	$Query;
	////Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
	//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
	//if post id is set, get data based on id. Else, get data based on post from client
		if(!empty($_POST["id"])){	
			$id = $_POST["id"];
			$_SESSION["id"] = $id;
			$data = Persons::Find($id);
			if(empty($data)){
				echo "error";
				exit;
				}
			}
		elseif(!empty($_SESSION["id"])){ 
			$id = $_SESSION["id"];
			$data = $_POST;
			$Query = $data;
			if(empty($data)){
				echo "error";
				exit;
			}
		}
	}
	
	elseif(!empty($_GET)){
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		if(!empty($_GET["id"])){	
			$id = $_GET["id"];
			$_SESSION["id"] = $id;
			$data = Persons::Find($id);
			if(empty($data)){
				echo "error";
				exit;
			}
		}
		elseif(!empty($_SESSION["id"])){ 
			$id = $_SESSION["id"];
			$data = $_GET;
			$Query = $data;
			if(empty($data)){
				echo "error";
				exit;
			}
		}
	}
	else {
        echo "error";
        exit;
    }
	
	
	////post will not be considered empty if the create button on create.html was clicked,
	////even if there is no data in post. This is why post must be validated.
	//
	if ( !empty($Query)) {
		// if there is nothing in post, just continue to html as normal
			//if there are no errors, prepare to insert data
			$Errors = array();
			$ValuesAndColumns = array();
			foreach($columns as $columnKey => $columnText){
				$ValuesAndColumns[$columnKey] = $Query[$columnKey];
			}
				$p = md5($ValuesAndColumns["password_hash"]);
				$ValuesAndColumns["password_hash"] = $p;
				$data = $ValuesAndColumns;
				//check that data is valid
				$errors = PersonsValidation::CheckEmpty($data);
				if(empty($errors)){
					$errors = PersonsValidation::ValidatePerson($data);
				}
			//if data is valid, return to index
			if(empty($errors) || $errors === true){
					Persons::Update($ValuesAndColumns, $id);
					$data = null;
					$errors = null;
					echo "success";
					exit;
			}	
	} 
	?>			
		<div id="Courselist">
		<?php
		
				foreach($columns as $columnkey => $columnValue){
					$isPassword = false;
					$pos = strpos($columnkey, 'pass');
					$dataItem = $data[$columnkey];
    
					$error = $errors[$columnkey];
				if (!($pos === false)){
					echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
						<label class='control-label'>" . "Change ". trim($columnValue) . "</label>
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
}
		?>