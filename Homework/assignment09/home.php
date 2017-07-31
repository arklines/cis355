<?php
session_start();
 
//connect to database
$db=mysqli_connect("localhost","arklines","560431","arklines");
mysqli_connect()
 
 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register , login and logout user php mysql</title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="header">
    <h1>Register, login and logout user php mysql</h1>
</div>
<?php
    if(isset($_SESSION['message']))
    {
         echo "<div id='error_msg'>".$_SESSION['message']."</div>";
         unset($_SESSION['message']);
    }
?>
<h1>Home</h1>
<?php if (isset($_SESSION['username'])){ 
		echo "<div>
		<h4>Welcome " . $_SESSION['username'] . "</h4></div>
		</div>
		<a href='logout.php'>Log Out</a>";
		}
	else{
		echo"<div>
			<h4>You are not logged in</h4>
			</div>
			<a href='login.php'>Log in</a>
			<a href='register.php'>Register</a>";
	}
?>
</body>
</html>