<?php
session_start();
	if(isset($_SESSION["user"])){
		$user = $_SESSION["user"];
		if(!isset($_COOKIE["LastSearch"])){
		echo "no cookies (aww, man.)";
		}
		else{
			echo $user . " Past searchs: </br>";
			if(isset($_COOKIE["searchCounter"])){
				echo "Number of searches: ";
				$cookie = $_COOKIE["searchCounter"];
				echo $cookie . "</br>";
				$cookieName = "LastSearch";
				echo "Last search string: " . $_COOKIE[$cookieName] . "</br>";
					
					echo "</br>";
			}
		}
	}
	else{
		echo "You haven't searched for anything yet";
	}
	
	