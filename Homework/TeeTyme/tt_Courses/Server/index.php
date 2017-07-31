<?php
include '../CoursesTableDataGateway/Courses.php'; ?>
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
						<?php
						//Add headers for each visible column name for Courses
						$columns = Courses::ReturnColumnsKeyPair();
						foreach($columns as $columnKey => $columnText){
							echo "<th>" . $columnText . "</th>" ;
						}
						echo "<th>Action</th>";
						?>
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
                               echo '<td width=250>';
                               echo '<a class="btn" href="read.html?id='.$row['id'].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="update.html?id='.$row['id'].'">Update</a>';
                               echo ' ';
                               echo '<a class="btn btn-danger" href="delete.html?id='.$row['id'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                      }
                      ?>
                      </tbody>
                </table>

 