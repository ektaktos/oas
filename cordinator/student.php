<?php
	require 'connect.php';
	require_once 'valid.php';
?>	
<!DOCTYPE html>
<html lang = "eng">
	<head>
		<title>ASG System</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css"/>
		 <link href="assets/css/bootstrap.css" rel="stylesheet">
	</head>
	<body style = "background-color:#d3d3d3;">
		<?php include 'navigation.php'; ?>
		<div class = "container-fluid">
			<div class = "col-lg-1"></div>
			<div class = "col-lg-12 well" style = "margin-top:60px;">
				<div class = "alert alert-info">Accounts / Student</div>
					<button id = "add_student" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Add new</button>
					<button id = "show_student" type = "button" style = "display:none;" class = "btn btn-success"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Back</button>
					<br />
					<br />
					<div id = "student_table">
						<table id = "table" class = "table table-bordered">
							<thead class = "alert-success">
								<tr>
									<th>Matric No. </th>
									<th>Full Name</th>
									<th>Phone</th>
									<th>Email</th>
									<th>Course</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sql = $conn->query("SELECT * FROM student") or die(mysqli_error());
									while($row = $sql->fetch_assoc()){
									$courses = $row["courses"];
								?>
								<tr>
									<td><?php echo $row['MatricNum']?></td>
									<td><?php echo $row['Name']?></td>
									<td><?php echo $row['phone']?></td>
									<td><?php echo $row['email']?></td>
								<?php
									if(!empty($courses) ){
										$d_courses = implode(", ",json_decode($courses));
										echo '<td>'. $d_courses .'</td>'; //Conversion of Array to String.
									}else{
										echo '<td>'. $courses .'</td>';
									}
								?>
									<td><a  value = "<?php echo $row['MatricNum']?>" class = "btn btn-danger btn-xs delmatric_num"><span class = "glyphicon glyphicon-remove"></span> Delete</a> <a class = "btn btn-warning btn-xs ematric_num" value = "<?php echo $row['MatricNum']?>"><span class = "glyphicon glyphicon-edit"></span> Edit</a></td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<div id = "edit_form"></div>
					<div id = "student_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form method = "POST" action = "save_student_query.php" enctype = "multipart/form-data">	
								<div class = "form-group">	
									<label>Matric No.:</label>
									<input type = "text" name = "MatricNum" required = "required" class = "form-control" />
								</div>	
								<div class = "form-group">	
									<label>Firstname:</label>
									<input type = "text" name = "firstname" required = "required" class = "form-control" />
								</div>
								<div class = "form-group">	
									<label>Lastname:</label>
									<input type = "text" name = "lastname" required="required" class = "form-control" />
								</div>	
								<div class = "form-group">	
									<label>Phone:</label>
									<input type = "text" required = "required" name = "phone" class = "form-control" />
								</div>
								<div class = "form-group">	
									<label>Email:</label>
									<input type = "text" required = "required" name = "email" class = "form-control" />
								</div>
								<div class="form-group">
									<label>Course:</label>
									<select class="form-control selectpicker" id="courses" name="courses[]" multiple>
										<option value="" disabled="disabled"> Select Courses </option>
										<?php 
										$sql = mysqli_query($conn, "SELECT * FROM course ORDER BY courseName ASC");
										while ($row = mysqli_fetch_array($sql))
										{
										?>
											<option  value="<?php echo $row["courseCode"] ?>"> <?php echo $row['courseCode'] ?> - <?php echo $row['courseName'] ?> </option>
										<?php

										foreach($_POST['courses'] as $selected){
											echo '$selected';
										}
										}
										?>
								</select>
								</div>
								<div class = "form-group">	
									<label>Password:</label>
									<input type = "text" required = "required" name = "password" class = "form-control" />
								</div>	
								<div class = "form-group">	
									<button class = "btn btn-primary" name = "save_student"><span class = "glyphicon glyphicon-save"></span> Submit</button>
								</div>
							</form>		
						</div>	
					</div>
			</div>
		</div>
		<br />
		<br />
		<br />
		<nav class = "navbar navbar-default navbar-inverse navbar-fixed-bottom">
			<div class = "container-fluid">
				<label class = "navbar-text pull-right">Library System &copy; All rights reserved 2016</label>
			</div>
		</nav>
	</body>
	<script src = "assets/js/jquery.js"></script>
	<script src = "assets/js/bootstrap.js"></script>
	<script src = "assets/js/jquery.dataTables.js"></script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#add_student').click(function(){
				$(this).hide();
				$('#show_student').show();
				$('#student_table').slideUp();
				$('#student_form').slideDown();
				$('#show_student').click(function(){
					$(this).hide();
					$('#add_student').show();
					$('#student_table').slideDown();
					$('#student_form').slideUp();
				});
			});
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Deleting...</label></center>');
			$('.delmatric_num').click(function(){
				$MatricNum = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.delmatric_num').attr('disabled', 'disabled');
				$('.ematric_num').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'delete_student.php?MatricNum=' + $MatricNum;
				}, 1000);
			});
			$('.ematric_num').click(function(){
				$MatricNum = $(this).attr('value');
				$('#show_student').show();
				$('#show_student').click(function(){
					$(this).hide();
					$('#edit_form').empty();
					$('#student_table').show();
					$('#add_student').show();
				});
				$('#student_table').fadeOut();
				$('#add_student').hide();
				$('#edit_form').load('load_student.php?MatricNum=' + $MatricNum);
			});
		});
	</script>
</html>