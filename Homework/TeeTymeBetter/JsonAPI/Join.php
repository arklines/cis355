<?php
//This file echoes out a json file giving information on ongoing rounds and their associated members and courses
    include_once '../config.php';
	include_once(ROOT_DIR . '/InputObjects/InputObject.php');
    require '../tt_rounds/RoundsTableDataGateway/Rounds.php';
	 require('../tt_persons/PersonsTableDataGateway/Persons.php');
	 require('../tt_Courses/CoursesTableDataGateway/Courses.php');

	
	$RoundsTable = new Rounds;
	$PersonsTable = new Persons;
	$CoursesTable = new Courses;
	$data = array();
	$rounds = $RoundsTable->FindAll()->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($rounds as $round){
		
		$person = $PersonsTable->Find($round["person_id"]);
		$person =  $person["lname"] . ", " . $person["fname"];
		$courses = $CoursesTable->Find($round["course_id"]);
		$data[$round["id"]] = array($person=>array($courses["name"]=>$round));
	}
			echo json_encode($data);

?>