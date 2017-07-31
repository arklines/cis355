<?php

session_start();
include_once '../../Database/database.php';
//$TableDataGateway design pattern for table Courses
class Persons
{	
		public function insert($data){	
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Best dynamic insert I've ever seen, from Galen on StackOverflow. I forgot that you could use implode directly on array_keys/values like this. Also, sprintf gives much nicer readability
				$sql = sprintf(
						'INSERT INTO tt_persons (%s) VALUES ("%s")',
						implode(',',array_keys($data)),
						implode('","',array_values($data))
						);
				$q = $pdo->prepare($sql);
				$q->execute(array($data));
				Database::disconnect();
				
					return "success";
		}
		
		public function Update($data, $ID){	
			if ( null==$UID ) {
				
			} 		
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
				try{	
					$content= implode(', ', array_map(
					function ($v, $k) {
					return $k. "=" . (!empty($v) ? "'" . $v . "'" : "' '" );
					},
					$data,
					array_keys($data)
				));
				$sql = sprintf("UPDATE tt_persons SET %s WHERE id=?", $content);
            
				$q = $pdo->prepare($sql);
				$q->execute(array($ID));
				Database::disconnect();
				}
			
				catch(Exception $e){
					return $e;
				}	
					return "";
		}
		
		public function Find($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM tt_persons where id = ?";
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
				$sql = "DELETE FROM tt_persons where id = ?";
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
				$sql = "SELECT * FROM tt_persons ORDER BY id DESC";
				//query, which returns multiple rows
				$q = $pdo->query($sql);
				//execute prepared statement, with variable array
				Database::disconnect();
				return $q;
		}
		
		public function ReturnColumnsKeyPair(){
			$columns = array(
			"fname" => "First Name",
			"lname" => "Last Name",
			"email" => "Email",
			"password_hash" => "Password",
			"phone" => "Phone Number",
			"address" => "Address",
			"city" => "City",
			"state" => "State",
			"zip" => "Zip Code"
		);
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
		
		public function UserLogin($email, $hash){
			 if ( null==$email || null==$hash) {
				
			} else {
	
				try{
				$pdo = Database::connect();
				//$sql = "SELECT * FROM tt_persons where email = ? and password_hash = ?";
				$sql = "SELECT * FROM tt_persons where email = '" . $email . "' and password_hash = '" . $hash . "'";
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//prepare prepares replacement sql statement, so that wildcards can be
				//replaced with an array of parameters
				//$q = $pdo->prepare($sql);
				//$q->execute(array("'" . $email . "'", "'" . $hash . "'"));
				$q= $pdo->query($sql);
				$q->execute();
				//fetch a row
				$data = $q->fetch(PDO::FETCH_ASSOC);
				Database::disconnect();
				}
				catch(Exception $e){
					return $e->message;
				}
				if(!(empty($data))){
				$user = $data;
				return "success";
				}
				else{
				return "User does not exist";
				}
				}
		}

}
?>

