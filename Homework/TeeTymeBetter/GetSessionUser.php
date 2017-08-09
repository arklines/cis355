<?php
session_start();
	if(!empty($_SESSION["user"])){
		echo "<div class='control-group '>
					<label id='Session-label' color='white'>Welcome " . $_SESSION["user"] . "</label>
					<a href='/~arklines/cis355/Homework/TeeTymeBetter/tt_persons/logout.html'>Logout</a></div>";
	}
	else{
		echo "<a href='/~arklines/cis355/Homework/TeeTymeBetter/tt_persons/Login.html'>Login</a>";
	}
?>