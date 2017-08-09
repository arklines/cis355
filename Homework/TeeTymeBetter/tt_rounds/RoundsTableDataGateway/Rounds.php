<?php
include_once(ROOT_DIR . '/Database/database.php');
include_once '../../config.php';
include_once(ROOT_DIR . '/TableObject/Table.php');
//$TableDataGateway design pattern for table Courses
class Rounds
{	
		private $TableCourse;
		function __construct(){
			$this->TableRound = new Table("tt_rounds");
		}
		public function insert($data){	
			// insert data
			// data has been validated to be in m/d/y format. It must be inserted in y-m-d format
			$date = $data["teedate"];
			$date = DateTime::createFromFormat('m-d-y', $date);
			$date = $date->format('Y-m-d');
			$data["teedate"] = $date;
			try{
			 $this->TableRound->insert($data);
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
					// data has been validated to be in m/d/y format. It must be inserted in y-m-d format
				$date = $data["teedate"];
				$date = DateTime::createFromFormat('m-d-y', $date);
				$date = $date->format('Y-m-d');
				$data["teedate"] = $date;
					try{
					$this->TableRound->Update($data, $ID);
					}
					catch(Exception $e){
						return $e->getMessage;
					}	
						return "success";
				}
		}
			
		
		public function Find($UID){
			if ( null==$UID ) {
				
			} else {
				$data = $this->TableRound->Find($UID);
				if(!(empty($data))){
				return $data;}
				else{	
					
				}	
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$this->TableRound->Delete($UID);
			}
			return "";
		}
		
		public function FindAll(){
				$q = $this->TableRound->FindAll();
				return $q;
		}
		
		public static function ReturnColumnsKeyPair(){
			$columns = array(
			"person_id" => "Person",
			"course_id" => "Course",
			"teedate" => "Tee Date",
			"teetime" => "Tee Time",
			"strokes01" => "Strokes 1",
			"strokes02" => "Strokes 2",
			"strokes03" => "Strokes 3",
			"strokes04" => "Strokes 4",
			"strokes05" => "Strokes 5",
			"strokes06" => "Strokes 6",
			"strokes07" => "Strokes 7",
			"strokes08" => "Strokes 8",
			"strokes09" => "Strokes 9",
			"strokes10" => "Strokes 10",
			"strokes11" => "Strokes 11",
			"strokes12" => "Strokes 12",
			"strokes13" => "Strokes 13",
			"strokes14" => "Strokes 14",
			"strokes15" => "Strokes 15",
			"strokes16" => "Strokes 16",
			"strokes17" => "Strokes 17",
			"strokes18" => "Strokes 18"
		);
		////this is a key-value pair, where the key is the column for sql access, and the 
		////value is for visual display
		return $columns;
		}
		
		public static function  ReturnInsesrtColumnsKeyPair(){
			$columns = array(
			"person_id" => "Person",
			"course_id" => "Course",
			"teedate" => "Tee Date",
			"teetime" => "Tee Time"
		);
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
		
		public static function ReturnDisplayColumnsKeyPair(){
			$columns = array(
			"teedate" => "Tee Date",
			"teetime" => "Tee Time"
		);
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
}



?>

