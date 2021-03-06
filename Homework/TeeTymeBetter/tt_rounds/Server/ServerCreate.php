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
	$errors = array();
	$data = array();
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
			$errors = array();
			$ValuesAndColumns = array();
			foreach($columns as $columnKey => $columnText){
				$ValuesAndColumns[$columnKey] = $Query[$columnKey];
			}
				$data = $ValuesAndColumns;
				//check that data is valid
				$errors = RoundsValidation::CheckEmpty($data);
				//if data isn't empty, validate data
				if(empty($errors)){
					$errors1 = RoundsValidation::ValidateRounds($data);
					$errors2 = RoundsValidation::ValidateNumerics($data);
					$errors = array_merge($errors1, $errors2);
				}
			//if data is valid try to insert, return status
			if(empty($errors) || $errors === true){
				$status = "success";
				try{
					$status = $RoundsTable->insert($ValuesAndColumns);
				}	
				catch(Exception $e){
					$status =  $e->getMessage();
				}
				$data = null;
				$errors = null;
			}	
    }
    if($status==="success" || $status ==="error"){
		echo $status;
	}
	else{
		echo $status;
		echo "<div class='control-group " . (!empty($errors['person_id'])?'error':'') . "'>"?>		
		<label for="person_id">Person</label>
		<select name="person_id" id="person_id">
        <option >Select a Person:</option>
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
		<?php echo "<div class='control-group " . (!empty($errors['course_id'])?'error':'') . "'>"?>	
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
				foreach($displayColumns as $columnkey => $columnValue){
					
				if(!empty($data[$columnkey])){
				$dataItem = $data[$columnkey];}
				if(!empty($errors[$columnkey])){
				$error = $errors[$columnkey];}
        
				InputObjects::EchoInputGroup($columnkey, $columnValue, $dataItem, $error);
				}
				?>
		<?php
			}
		?>




