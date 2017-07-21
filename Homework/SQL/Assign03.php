<!DOCTYPE html>
<html lang="en">
 
 <?php
     
    $localhost = "localhost";
	$username  = "arklines";
	$password  = "560431";
	$database  = "arklines";
	// Create Connection
	$pdo = new PDO(  "mysql:host={$localhost};" .  "dbname={$database}",  $username,   $password);
	
	// Get Records
	$sql = "SELECT * FROM persons";
	$q   = $pdo->query($sql, PDO::FETCH_ASSOC);
	$sqlCourse = "SELECT * FROM courses";
	$qCourse   = $pdo->query($sqlCourse, PDO::FETCH_ASSOC);
	// Display Records
	//foreach($q as $rec)     
	//echo "{$rec['fname']}{$rec['lname']} <br>";
	?>
	<form action="Assign03.php" method="post">
	<p>
      <label for="Person">Person</label>
      <select name="Person" id="Per">
        <option>Select a Person:</option>
    <?php
    foreach($q as $rec){
		  unset($id, $name);
                  $id = $rec['id'];
                  $name = $rec['lname'] . ", " . $rec['fname']; 
                  echo '<option value="'.$id.'">'.$name.'</option>';
	}
?>
</select></p>

<p>
      <label for="Courses">Courses</label>
      <select name="Course" id="Course">
        <option>Select a Course:</option>
    <?php
    foreach($qCourse as $rec){
		  unset($id, $name);
                  $id = $rec['id'];
                  $name = $rec['tetle']; 
                  echo '<option value="'.$id.'">'.$name.'</option>';
	}
?>
</select></p>
<input type="submit" name="submitBttn" value="Submit">
<?php
$selectOptionPerson = $_POST['Person'];
$selectOptionCourse = $_POST['Course'];
$sqlCourse = "INSERT INTO `enrollments`(`fk_courses`, `fk_persons`) VALUES ($selectOptionCourse, $selectOptionPerson)";
	$qCourse   = $pdo->query($sqlCourse, PDO::FETCH_ASSOC);
?>
</html>