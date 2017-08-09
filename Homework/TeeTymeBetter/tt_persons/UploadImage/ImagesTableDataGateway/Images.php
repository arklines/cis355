<?php
include_once(ROOT_DIR . '/Database/database.php');
include_once '../../config.php';
include_once(ROOT_DIR . '/TableObject/Table.php');
session_start();
//$TableDataGateway design pattern for table Courses
class Images
{		private $TablePerson;
		function __construct(){
			$this->TableImage = new Table("tt_pictures");
		}
		public function insert($data){	
			try{
			 $this->TableImage->insert($data);
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
				$this->TableImage->UpdateByPerson($data, $ID);
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
				$data = $this->TableImage->FindByPerson($UID);
				if(!(empty($data))){
				return $data;}
				else{	
					
				}
			}
		}
		
		public function Delete($UID){
			if ( null==$UID ) {
				
			} else {
				$this->TableImage->Delete($UID);
			}
			return "";
		}
		
		public function FindAll(){
			//	$q = array();
				$q = $this->TableImage->FindAll();
				return $q;
		}
		
		public function ReturnColumnsKeyPair(){
			$columns = array(
			"image" => "Image",
			"name" => "Image Name",
			"size" => "Image Size",
			"type" => "Image Type",
		);
		//this is a key-value pair, where the key is the column for sql access, and the 
		//value is for visual display
		return $columns;
		}
		

}
?>

