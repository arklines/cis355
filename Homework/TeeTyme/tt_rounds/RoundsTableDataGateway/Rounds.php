<?php
include_once '../../Database/database.php';
//$TableDataGateway design pattern for table Courses
class Rounds
{	
		public function insert($data){	
			// insert data
			// data has been validated to be in m/d/y format. It must be inserted in y-m-d format
			$date = $data["teedate"];
			$date = DateTime::createFromFormat('m-d-y', $date);
			$date = $date->format('Y-m-d');
			$data["teedate"] = $date;
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Best dynamic insert I've ever seen, from Galen on StackOverflow. I forgot that you could use implode directly on array_keys/values like this. Also, sprintf gives much nicer readability
				$sql = sprintf(
						'INSERT INTO tt_rounds (%s) VALUES ("%s")',
						implode(',',array_keys($data)),
						implode('","',array_values($data))
						);
				$q = $pdo->prepare($sql);
				$q->execute(array($data));
				Database::disconnect();
					return "success";
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
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$content= implode(', ', array_map(
					function ($v, $k) {
					return $k. "=" . (!empty($v) ? "'" . $v . "'" : "' '" );
					},
					$data,
					array_keys($data)
				));
				$sql = sprintf("UPDATE tt_rounds SET %s WHERE id=?", $content);

				try{
				$q = $pdo->prepare($sql);
				$q->execute(array($ID));
				Database::disconnect();
				}
				catch(Exception $e){
					return $e->getMessage();
				}	
					return "success";
			}
		}
		
		public function Find($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM tt_rounds where id = ?";
				//prepare prepares replacement sql statement, so that wildcards can be
				//replaced with an array of parameters
				$q = $pdo->prepare($sql);
				$q->execute(array($UID));
				//fetch a row
				$data = $q->fetch(PDO::FETCH_ASSOC);
				Database::disconnect();
				if(!(empty($data))){
				return $data;}
				else{	
					
				}
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "DELETE FROM tt_rounds where id = ?";
				//prepare prepares replacement sql statement, so that wildcards can be
				//replaced with an array of parameters
				$q = $pdo->prepare($sql);
				$q->execute(array($UID));
				//fetch a row
				Database::disconnect();
			}
			return "";
		}
		
		public function FindAll(){
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM tt_rounds ORDER BY id DESC";
				//query, which returns multiple rows
				$q = $pdo->query($sql);
				//execute prepared statement, with variable array
				Database::disconnect();
				return $q;
		}
		
		public function ReturnColumnsKeyPair(){
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
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
		
		public function ReturnInsesrtColumnsKeyPair(){
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
		public function ReturnDisplayColumnsKeyPair(){
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

