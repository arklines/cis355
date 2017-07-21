<?php
include_once '../Database/database.php';
include_once 'CoursesValidation.php';
//$TableDataGateway design pattern for table Courses
class Courses
{	
		public function insert($data){

			$valid = array();
			$emptyErrors = CoursesValidation::CheckEmpty($data);
			if(!empty($emptyErrors)){
			return $emptyErrors;}
			
			//$valid = CoursesValidation::ValidateCourse($data);
			
			//if(!empty($valid)){
			//return $valid;}
				
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO tt_courses (";
				$paramStr = "(";
				$valueSet = array();
				$i = 0;
			foreach($data as $key => $value){
				$sql = $sql . "" . $key . ", ";
				$paramStr = $paramStr . "?,";
				$valueSet[$i] = $value;
				$i = $i +1;
			} 
			
				//remove last comma
				$sql = substr($sql, 0, -2) . ")";
				$paramStr = substr($paramStr, 0, -1) . ")";
			
				$sql = $sql . " values" . $paramStr;
				echo $sql;
				try{
				$q = $pdo->prepare($sql);
				$q->execute($valueSet);
				Database::disconnect();
				}
				catch(Exception $e){
					return $e;
				//header("Location: index.php");
				}	
				header("Location: index.php");
					return "";
		}
		
		public function Find($UID){

			if ( null==$UID ) {
				header("Location: index.php::Find");
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM tt_courses where id = ?";
				//prepare prepares replacement sql statement, so that wildcards can be
				//replaced with an array of parameters
				$q = $pdo->prepare($sql);
				$q->execute(array($UID));
				//fetch a row
				$data = $q->fetch(PDO::FETCH_ASSOC);
				Database::disconnect();
				header("Location: index.php");
				return $data;
			}
		}
		
		public function FindAll(){
			
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM tt_courses ORDER BY id DESC";
				//query, which returns multiple rows
				$q = $pdo->query($sql);
				//execute prepared statement, with variable array
				Database::disconnect();
				return $q;
		}
		
		public function ReturnColumnsKeyPair(){
			$columns = array(
			"name" => "Name",
			"description" => "Description",
			"email" => "Email",
			"address" => "Address",
			"city" => "City",
			"state" => "State",
			"zip" => "Zip Code",
			"phone" => "Phone Number",
			"par01" => "Par 1",
			"par02" => "Par 2",
			"par03" => "Par 3",
			"par04" => "Par 4",
			"par05" => "Par 5",
			"par06" => "Par 6",
			"par07" => "Par 7",
			"par08" => "Par 8",
			"par09" => "Par 9",
			"par10" => "Par 10",
			"par11" => "Par 11",
			"par12" => "Par 12",
			"par13" => "Par 13",
			"par14" => "Par 14",
			"par15" => "Par 15",
			"par16" => "Par 16",
			"par17" => "Par 17",
			"par18" => "Par 18"
		);
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
}



?>

