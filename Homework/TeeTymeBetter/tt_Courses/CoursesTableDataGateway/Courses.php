<?php
include_once(ROOT_DIR . '/Database/database.php');
include_once '../../config.php';
include_once(ROOT_DIR . '/TableObject/Table.php');
//$TableDataGateway design pattern for table Courses
class Courses
{	
		private $TableCourse;
		function __construct(){
			$this->TableCourse = new Table("tt_courses");
		}
		public function insert($data){	
			try{
			 $this->TableCourse->insert($data);
			}
			catch(Exception $e){
				return $e->getMessage();
			}
		}
		
		public function Update($data, $ID){	
			if ( null==$ID ) {
				echo "error";
			} 
			else{
			
				try{
				$this->TableCourse->Update($data, $ID);
				}
				catch(Exception $e){
					return $e->getMessage;
				}	
					return "";
			}
		}
		
		public function Find($UID){
			if ( null==$UID ) {
				
			} else {
				$data = $this->TableCourse->Find($UID);
				if(!(empty($data))){
				return $data;}
				else{	
					
				}
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$this->TableCourse->Delete($UID);
			}
			return "";
		}
		
		public function FindAll(){
			//	$q = array();
				$q = $this->TableCourse->FindAll();
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

