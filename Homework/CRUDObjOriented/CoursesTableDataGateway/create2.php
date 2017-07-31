<!DOCTYPE html>
<html lang="en">
 <meta charset="utf-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/MenuHeadBootstrap.css" rel="stylesheet">
	<script src="../js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
   <title>CIS-355 > Allison Klinesmith</title>
	
	</head>
	<body>
	  <?php
	
    require 'Courses.php';
	include_once 'CoursesValidation.php';
	
	$columns = Courses::ReturnColumnsKeyPair();
	
	//post will not be considered empty if the create button on create.html was clicked,
	//even if there is no data in post. This is why post must be validated.
	
    if ( !empty($_POST)) {
		// if there is nothing in post, just continue to html as normal
		if(!empty($_POST["errors"])){
			//check for errors in post, to be displayed
			//in the case of errors from post, get errors and values,
			//so that html can set them to the controls
			$errors = $_POST["errors"];
			foreach($columns as $columnKey => $columnText){
				$data[$columnKey] = $_POST[$columnKey];
			}
		}
		else{
		//	//if there are no errors, prepare to insert data
			$Errors = array();
			$ValuesAndColumns = array();
			foreach($columns as $columnKey => $columnText){
				$ValuesAndColumns[$columnKey] = $_POST[$columnKey];
			}
				$data = $ValuesAndColumns;
		//		//check that data is valid
				$errors = CoursesValidation::CheckEmpty($data);
		//	//if data is valid, return to index
			if(empty($errors) || $errors === true){
					Courses::insert($ValuesAndColumns);
					header("Location: index.php");
			}
		
		}
    }

	
?>
	
	<?php
	<!-- Dynamic container which, using ajax, will contain a set of input fields for each available field within create.php-->
    <div class="container">
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Course</h3>
                    </div>
                    <form action="create2.php" method="post" class="form-horizontal" >
						<!-- divs will load here -->
						<div class="CourseInputList">
						<?php 
						foreach($columns as $columnkey => $columnValue){
		
						$dataItem = $data[$columnkey];

						$error = $errors[$columnkey];

						echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
                        <label class='control-label'>" . trim($columnValue) . "</label>
                        <div class='controls'>
                            <input name='" . $columnkey . "' type='text'  placeholder='" . $columnkey . "' value='" .  (!empty($dataItem)?$dataItem:'') . "'>" .
                                (!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
                             "</div></div>";
	}
						?>
						</div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>



