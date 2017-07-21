<?php
	
    require 'Courses.php';

	
	$columns = Courses::ReturnColumnsKeyPair();
    
	//post will not be considered empty if the create button on create.html was clicked,
	//even if there is no data in post. This is why post must be validated.
    if ( !empty($_POST)) {
    //    // keep track validation errors
    $Errors = array();
	$ValuesAndColumns = array();
	foreach($columns as $columnKey => $columnText){
		$ValuesAndColumns[$columnKey] = $_POST[$columnKey];
	}
		$_SESSION['data'] = $ValuesAndColumns;
		$_SESSION['errors'] = Courses::insert($ValuesAndColumns);
        //
	if(empty($_SESSION['errors']) || $_SESSION['errors'] === true){
			echo "success";
			header("Location: index.php");
	}
    else{
			
		// header('HTTP/1.1 500 Internal Server Booboo');
		//header('Content-Type: application/json; charset=UTF-8');
		//die(json_encode($Errors));
		//errors::ReceiveErrors($Errors);
		header("Location: create.html");
		}
	
    }
	//
	else{
		echo json_encode($columns);
	}
	
?>