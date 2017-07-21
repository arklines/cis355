<?php
    include 'Courses.php';
	
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
		$data = Courses::Find($id);
    }
	$columns = Courses::ReturnColumnsKeyPair();
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/MenuHeadBootstrap.css" rel="stylesheet">
	<script src="../js/jquery.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read a Customer</h3>
                    </div>
                     
                    <div class="form-horizontal" id="readBody">
					<!-- test out iterative through all columns-->
					
					<?php foreach($columns as $key=>$value){
						echo "<div class=\"control-group\">
                        <label class=\"control-label\">" . $value . "</label>
                        <div class=\"controls\">
                            <label class=\"checkbox\">" . 
							$data[$key] .
                          "</label>
                        </div>
                      </div>";
					};?> 
					<!-- -->
                        <div class="form-actions">
                          <a class="btn" href="index.php">Back</a>
                       </div>  
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>