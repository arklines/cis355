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
	 require('../../tt_persons/PersonsTableDataGateway/Persons.php');
	  require('../../tt_Courses/CoursesTableDataGateway/Courses.php');
	include_once '../RoundsTableDataGateway/RoundsValidation.php';
	session_start();
	
	$RoundsTable = new Rounds;
	$PersonsTable = new Persons;
	$CoursesTable = new Courses;
	$columns = $RoundsTable->ReturnColumnsKeyPair();
	$displayColumns = $RoundsTable->ReturnDisplayColumnsKeyPair();
	$persons = $PersonsTable->FindAll();
	$courses = $CoursesTable->FindAll();
	$id;
	//Check for get and post methods. Prepare to process either one.
	if ( !empty($_POST)) {
		//if ID is set, fetch data for id. Otherwise, the user has edited the data. Prepare to submit edits.
		//if post id is set, get data based on id. Else, get data based on post from client
		if(!empty($_POST["id"])){	
			$id = $_POST["id"];
			$_SESSION["id"] = $id;
			$data = $RoundsTable->Find($id);
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
			$data = $RoundsTable->Find($id);
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
		$date = $data["teedate"];
				$date = DateTime::createFromFormat('Y-m-d', $date);
				$date = $date->format('m-d-y');
				$data["teedate"] = $date;
		$time = new DateTime($data["teetime"]);
				$time = $time ->format('h:i:s a');
				$data["teetime"] = $time;
	if ( !empty($Query)) {
		// if there is nothing in post, just continue to html as normal
			//if there are no errors, prepare to insert data
			$Errors = array();
			$ValuesAndColumns = array();
			foreach($columns as $columnKey => $columnText){
				$ValuesAndColumns[$columnKey] = $Query[$columnKey];
			}
				$data = $ValuesAndColumns;
				
				//SQL dates are formatted into y-m-d. Format it back to read it - update and insert
				//will format dates back into y-m-d.
				
				//check that data is valid
				$errors = RoundsValidation::CheckEmpty($data);
				if(empty($errors)){
					$errors1 = RoundsValidation::ValidateRounds($data);
					$errors2 = RoundsValidation::ValidateNumerics($data);
					$errors = array_merge($errors1, $errors2);
				}
			//if data is valid, return to index
			if(empty($errors) || $errors === true){
					$status = $RoundsTable->Update($ValuesAndColumns, $id);
					echo $status;
					$data = null;
					$errors = null;
					exit;
			}	
    } 
	?>			
		<div id="Roundlist">
		<div class='control-group '>		
		<label for="person_id">Person</label>
		<select name="person_id" id="person_id">
        <option>Select a Person:</option>
		<?php
		foreach($persons as $rec){
		  unset($id, $name);
                  $id = $rec['id'];
                  $name = $rec['lname'] . ", " . $rec['fname'];
				if($rec['id'] === $data['person_id']){	
				 echo '<option selected="selected" value="'.$id.'">'.$name.'</option>';
				}
				else{
                  echo '<option value="'.$id.'">'.$name.'</option>';
				}
			}
		?>
		</select>
		</div>
		<div class='control-group '>
		<label for="course_id">Course</label>
		<select name="course_id" id="course_id">
        <option>Select a Course:</option>
		<?php
		foreach($courses as $rec){
		  unset($id, $name);
                  $id = $rec['id'];
                  $name = $rec['name']; 
				  //if the option matches the data from post query, set it as selected. 
				  if($rec['id'] === $data['course_id']){
                  echo '<option selected="selected" value="'.$id.'">'.$name.'</option>';
				  }
				  else{
					echo '<option value="'.$id.'">'.$name.'</option>';  
				  }
			}
		?>
		</select>
		</div>
		<?php
		
				foreach($columns as $columnkey => $columnValue){
				$dataItem = $data[$columnkey];

				$error = $errors[$columnkey];
				if(!($colmnkey === 'course_id') && !($columnkey === 'person_id')){
				echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
                      <label class='control-label'>" . trim($columnValue) . "</label>
                      <div class='controls'>
                          <input name='" . $columnkey . "' type='text'  placeholder='" . $columnkey . "' value='" .  (!empty($dataItem)?$dataItem:'') . "'>" .
                              (!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
                           "</div></div>";
				}
				}
		?>