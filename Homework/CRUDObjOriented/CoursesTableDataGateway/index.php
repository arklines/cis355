<!DOCTYPE html>
<?php
include 'Courses.php'; ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/MenuHeadBootstrap.css" rel="stylesheet">
	<script src="../js/jquery.min.js"></script>
   <title>CIS-355 > Allison Klinesmith</title>
	<script type="text/javascript">
	$(function(){
	$("#header").load("/~arklines/cis355/header.html"); 
	});
	</script>
    <!-- Custom CSS -->
    <style>
    .menuHead {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }	
	
    </style>
	</head>
	<div id="header" class="menuHead"></div>
	<body>
	
    <div class="container">
            <div class="row">
                <h3>PHP CRUD Grid Courses</h3>
            </div>
            <div class="row">
                <p>
                    <a href="create.html" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered" width=100%>
                      <thead>
                        <tr>
						<?php
						//Add headers for each visible column name for Courses
						$columns = Courses::ReturnColumnsKeyPair();
						foreach($columns as $columnKey => $columnText){
							echo "<th>" . $columnText . "</th>" ;
						}
						?>
						<!--<th>Action</th>-->
                        </tr>                           
                      </thead>
                      <tbody>
                      <?php  
					  $data = Courses::FindAll(); 
						//using the known set of columns as an indexer, iterate across
						//each data item and add them to the table
                      foreach ($data as $row) {						 
                                echo '<tr>';
								foreach($columns as $columnKey => $columnText){
									echo '<td>'. $row[$columnKey] . '</td>';
								}
								//action buttons
                               // echo '<td width=250>';
                               // echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
                               // echo ' ';
                               // echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                               // echo ' ';
                               // echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
                               // echo '</td>';
                               // echo '</tr>';
                      }
                      ?>
                      </tbody>
                </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>