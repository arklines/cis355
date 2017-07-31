<?php
session_start();
if(empty($_SESSION["user"])){
		echo "NoUser";
		exit;
	}
	//Write php to catch the last person added to the round, by ID. Add the ID to SESSION, then call header
	//location to jump back to index.html   
	//Add id to cookies AND session. Cookies will act like a "grocery cart" in case the user
	//closes out of the app on accident. only Session affects what members appear in the table. If when SUBMIT is clicked in index.html there are members
	//pending (in cookies that are not in session), notify user of pending members. Same in the case of starting the app. After submit, clear cookies.
	
	header("Location: ../index.html");
?>