<?php
	require_once 'connect.php';
	$q_student = $conn->query("SELECT * FROM `student` WHERE `MatricNum` = '$_REQUEST[MatricNum]'") or die(mysqli_error());
	$f_student = $q_student->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "edit_student_query.php?MatricNum=<?php echo $f_student['MatricNum']?>" enctype = "multipart/form-data">	
		<div class = "form-group">	
			<label>Matric Number:</label>
			<input type = "text" name = "MatricNum" value = "<?php echo $f_student['MatricNum']?>" required = "required" class = "form-control" />
		</div>	
		<div class = "form-group">	
			<label>Full Name:</label>
			<input type = "text" name = "name" value = "<?php echo $f_student['Name']?>" required = "required" class = "form-control" />
		</div>	
		<div class = "form-group">	
			<label>Phone:</label>
			<input type = "text" required = "required" value = "<?php echo $f_student['phone']?>" name = "phone" class = "form-control" />
		</div>
		<div class = "form-group">
			<label>Email:</label>
			<input type = "text" required = "required" value = "<?php echo $f_student['email']?>" name = "email" class = "form-control" />
		</div>	
		<!-- <div class = "form-group">	
			<label>Yr&Section:</label>
			<input type = "text" maxlength = "12" name = "section" value = "<?php echo $f_student['section']?>" required = "required" class = "form-control" />
		</div> -->
		<div class = "form-group">	
			<button class = "btn btn-warning" name = "edit_student"><span class = "glyphicon glyphicon-edit"></span> Save Changes</button>
		</div>
	</form>		
</div>