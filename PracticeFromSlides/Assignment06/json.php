<?php  
//Had to remove class because the class Database you gave us doesn't actually have a prepare call.
 $localhost = "localhost";
	$username  = "arklines";
	$password  = "560431";
	$database  = "arklines";
	// Create Connection
	$pdo = new PDO(  "mysql:host={$localhost};" .  "dbname={$database}",  $username,   $password);

	 
	$mysqli = new mysqli($localhost, $username, $password, $database);
	// Get Records
	$sql = "SELECT * FROM PersonsContact";
	$q   = $pdo->query($sql, PDO::FETCH_ASSOC);

   
echo json_encode($q->fetchAll(PDO::FETCH_ASSOC));
?>