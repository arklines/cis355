<?php
include_once(ROOT_DIR . '/Database/database.php');
include_once '../../config.php';
//$TableDataGateway design pattern for table Courses
class Table
{	
		private $TableName = "";
		
		function __construct($Table_name){
			$this->TableName = $Table_name;
		}
		
		public function insert($data){	
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Best dynamic insert I've ever seen, from Galen on StackOverflow. I forgot that you could use implode directly on array_keys/values like this. Also, sprintf gives much nicer readability
				$sql = sprintf(
						'INSERT INTO %s (%s) VALUES ("%s")',
						$this->TableName,
						implode(',',array_keys($data)),
						implode('","',array_values($data))
						);
			try{
				$q = $pdo->prepare($sql);
				$q->execute($data);
			}
			catch(Exception $e){
				return $e->getMessage();
			}
			finally{Database::disconnect();}
			
		}
		
		public function Update($data, $ID){	
			if ( null==$ID ) {
				echo "error";
			} 
			else{
				// data has been validated to be in m/d/y format. It must be inserted in y-m-d format
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				//Get keys and data in proper format
				$content= implode(', ', array_map(
					function ($v, $k) {
					return $k. "=" . (!empty($v) ? "'" . $v . "'" : "' '" );
					},
					$data,
					array_keys($data)
				));
				$sql = sprintf("UPDATE %s SET %s WHERE id=?", $this->TableName, $content);

				try{
				$q = $pdo->prepare($sql);
				$q->execute(array($ID));
				Database::disconnect();
				}
				catch(Exception $e){
					return $e->getMessage();
				}	
				finally{Database::disconnect();}
					return "success";
			}
		}
		
		public function Find($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = sprintf("SELECT * FROM %s where id = ?", $this->TableName);
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
		
		public function FindByPerson($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = sprintf("SELECT * FROM %s where person_id = ?", $this->TableName);
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
		public function UpdateByPerson($data, $ID){	
			if ( null==$ID ) {
				echo "error";
			} 
			else{
				// data has been validated to be in m/d/y format. It must be inserted in y-m-d format
			// insert data
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				//Get keys and data in proper format
				$content= implode(', ', array_map(
					function ($v, $k) {
					return $k. "=" . (!empty($v) ? "'" . $v . "'" : "' '" );
					},
					$data,
					array_keys($data)
				));
				$sql = sprintf("UPDATE %s SET %s WHERE person_id=?", $this->TableName, $content);

				try{
				$q = $pdo->prepare($sql);
				$q->execute(array($ID));
				Database::disconnect();
				}
				catch(Exception $e){
					return $e->getMessage();
				}	
				finally{Database::disconnect();}
					return "success";
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = sprintf("DELETE FROM %s where id = ?", $this->TableName);
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
			$q = array();
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = sprintf("SELECT * FROM %s ORDER BY id DESC", $this->TableName);
				//query, which returns multiple rows
				$q = $pdo->prepare($sql);
				$q->execute();
				//execute prepared statement, with variable array
				Database::disconnect();
				return $q;
		}

}

?>

