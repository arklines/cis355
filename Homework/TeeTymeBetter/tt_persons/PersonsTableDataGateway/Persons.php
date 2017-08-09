<?php

include_once '../../config.php';
include_once(ROOT_DIR . '/Database/database.php');
include_once(ROOT_DIR . '/TableObject/Table.php');
session_start();
//$TableDataGateway design pattern for table Courses
class Persons
{		private $TablePerson;
		function __construct(){
			$this->TablePerson = new Table("tt_persons");
		}
		public function insert($data){	
			try{
			 $this->TablePerson->insert($data);
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
				$this->TablePerson->Update($data, $ID);
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
				$data = $this->TablePerson->Find($UID);
				if(!(empty($data))){
				return $data;}
				else{	
					
				}
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$this->TablePerson->Delete($UID);
			}
			return "";
		}
		
		public function FindAll(){
			//	$q = array();
				$q = $this->TablePerson->FindAll();
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
		
		public static function UserLogin($email, $hash){
			 if ( null==$email || null==$hash) {
				
			} else {
	    
			try{
				$pdo = Database::connect();
				//$sql = "SELECT * FROM tt_persons where email = ? and password_hash = ?";
				$sql = "SELECT * FROM tt_persons where email = '" . $email. "'";
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
				//$hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';
                //
				//if (password_verify('rasmuslerdorf', $hash)) {
				//	echo 'Password is valid!';
				//}
				
				if(password_verify($hash, $data["password_hash"])){
					return "success";
				}
				else{
				return "User does not exist";
				}
			}
		}

}
?>

