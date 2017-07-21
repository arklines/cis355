<?php
// REST (Representational State Transfer) allows anything to work with your data // that can send a HTTP request
// The most common methods used are GET, POST, PUT, and DELETE
// GET: Used to retrieve data from a resource
// POST: Used to create a new resource, but is considered unsafe
// PUT: Used to update a resource, but is considered unsafe
// DELETE: Used to delete a resource and also is unsafe
function get_student_info($id){
  $student_info = array();

  // Data that normally is pulled from a database
  switch($id){
	  
	  case 1:
		  $student_info = array("first_name" => "Dale", "last_name" => "Cooper", "address" => "123 Main St Yakima, WA");
		  break;
      case 2:
          $student_info = array("first_name" => "Harry", "last_name" => "Truman", "address" => "202 South St Vancouver, WA");
          break;
      case 3:
          $student_info = array("first_name" => "Shelly", "last_name" => "Johnson", "address" => "9 Pond Rd Sparks, NV");
          break;
      case 4:
          $student_info = array("first_name" => "Bobby", "last_name" => "Briggs", "address" => "14 12th St San Diego, CA");
          break;
      case 5:
          $student_info = array("first_name" => "Donna", "last_name" => "Hayward", "address" => "120 16th St Davenport, IA");
          break;

  }

  return $student_info;

}

function get_student_list(){

 // Data that normally is pulled from a database

 $student_list = array(array("id" => 1, "name" => "Dale Cooper"),
                       array("id" => 2, "name" => "Harry Truman"),
                       array("id" => 3, "name" => "Shelly Johnson"),
                       array("id" => 4, "name" => "Bobby Briggs"),
                       array("id" => 5, "name" => "Donna Hayward"));

 return $student_list;
     
}
// Execute the proper method above based on request
if(isset($_GET["action"])){ 

  switch($_GET["action"]){
      case "get_student_list":
          $value = get_student_list();
          break;
      case "get_student":
			$value = get_student_info($_GET["id"]);
          break;

    }

   

}
exit(json_encode($value));
?>
