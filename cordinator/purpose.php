<?php 
								$querySelectCourse = "SELECT * FROM course";  
								$resultSelectCourse = $conn->query($querySelectCourse);

								while ($row = mysqli_fetch_assoc($resultSelectCourse))
								{
									echo'<option value="'.$row["sn"].'"';
									if($row["sn"] = $_POST["courseCode"]) echo 'selected="selected"';
									echo '>'.$row["courseCode"].'</option>';
								}
										echo "</select>";
        							?>


        			<?php in_array($row->sn, $_POST['courses']) ? 'selected' : ''?> value="<?php echo $row["sn"] ?>"> <?php echo $row["courseCode"] ?> </option>'


        			
								<select class="form-control selectpicker" id="txtcourses" name="per_courses[]" multiple>
									<!-- <option value=""> Select Courses </option> -->
										<?php 
										$sql = mysqli_query($conn, "SELECT * FROM course ORDER BY courseName ASC");
										while ($row = mysqli_fetch_array($sql))
										{
										?>
											<option  value="<?php echo $row["sn"] ?>"> <?php echo per_courses ?> </option>
										<?php

										foreach($_POST['courses'] as $selected){
											echo '$selected';
										}
										}
										?>

							</select>