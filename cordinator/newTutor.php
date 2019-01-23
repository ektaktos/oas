<?php 
require_once 'valid.php';
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');
?>


<!DOCTYPE html>
<html lang = "eng">
	<head>
		<title>ASG System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content = "width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css"/>
		 <link href="assets/css/bootstrap.css" rel="stylesheet">
		 <!-- <link href="assets/css/bootstrap-multiselect.css" rel="stylesheet"> -->
		 <!-- <link href="../Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
	</head>
	<body style = "background-color:#d3d3d3;">
		<?php include 'navigation.php'; ?>
<div class = "col-lg-10 well" style="background: white; position:relative; left:8%;">
	<div id="wrapper" class="wrapper" style = "margin-top:30px;">
		<div class = "alert alert-info" style="text-align:center; font-size:20px;">Accounts/Lecturer</div>
			<div class = "col-lg-1"></div>
					<div class="table_responsive">
						<div align="right">
							<button id = "add_tutor" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Add new</button>
							<button id = "show_tutor" type = "button" style = "display:none;" class = "btn btn-success"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Back</button>
						</div>
						<br />
						<div id="alert_message"></div>
					<div id = "tutor_table">
						<table id="tutor_data" class ="table table-bordered table-striped">
							<thead class ="alert-success">
								<tr>
									<th>SN</th>
									<th>Full Name</th>
									<th>Staff ID</th>
									<th>Phone</th>
									<th>Email</th>
									<th>Assigned Courses</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
					</div>
			</div>
					<div id="tutor_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form method = "POST" action = "save_tutor_query.php" enctype = "multipart/form-data">
								<div class = "form-group">	
									<label>Firstname:</label>
									<input type = "text" name = "firstname" required = "required" class = "form-control" />
								</div>		
								<div class = "form-group">	
									<label>Lastname:</label>
									<input type = "text" required = "required" name = "lastname" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Staff ID:</label>
									<input type = "text" required = "required" name = "staffId" class = "form-control" />
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
									<input type = "password" maxlength = "12" name = "password" required = "required" class = "form-control" />
								</div>	
								
								<div class = "form-group">	
									<button class = "btn btn-primary" name = "save_tutor"><span class = "glyphicon glyphicon-save"></span> Submit</button>
								</div>
							</form>		
						</div>	
					</div>
</div>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div id="content-data"></div>
		</div>
		<!-- <nav class = "navbar navbar-default navbar-fixed-bottom">
			<div class = "container-fluid">
				<label class = "navbar-text pull-right">Assignment Submission & Grading System &copy; All rights reserved 2018</label>
			</div>
		</nav>
 -->
	</body>
	<script src = "assets/js/jquery.js"></script>
	<script src = "assets/js/bootstrap.js"></script>
	<script src = "assets/js/jquery.dataTables.js"></script>
	<!-- <script src="assets/js/bootstrap-multiselect.js"></script> -->

	<script type="text/javascript">

$(document).ready(function(){

	fetch_data();
	
	 function fetch_data()
	 {
	 	var dataTable = $('#tutor_data').DataTable({
	 	"processing": true,
	 	"serverSide": true,
	 	"order":[],
	 	"ajax":{
	 		url:"tutorReg.php",
	 		type:"POST"
	 	}

	 	});
	}
});
</script>	
<!-- script js for get edit data -->
<script type="text/javascript">
	$(document).on('click', '#getEdit', function(e){
		e.preventDefault();
		var per_sn = $(this).data('id');
		$('#content-data').html('');
		$.ajax({
			url:'editTutor.php',
			type:'POST',
			data:'id='+per_sn,
			dataType:'html'
		}).done(function(data){
			$('#content-data').html('');
			$('#content-data').html(data);
		})
	});
</script>
<script type = "text/javascript">
		$(document).ready(function(){
			$('#add_tutor').click(function(){
				$(this).hide();
				$('#show_tutor').show();
				$('#tutor_table').slideUp();
				$('#tutor_form').slideDown();
				$('#show_tutor').click(function(){
					$(this).hide();
					$('#add_tutor').show();
					$('#tutor_table').slideDown();
					$('#tutor_form').slideUp();
				});
			});
		});
	</script>
</html>
<?php
//Update
	if(isset($_POST['btnEdit']))
	{
		// die(var_dump($_POST['txtphone'], $_POST['txtemail'],$_POST['txtstaffid'],$_POST['txtname']));
		 $new_sn = mysqli_real_escape_string($conn, $_POST['txtsn']);
		 $new_name = mysqli_real_escape_string($conn, $_POST['txtname']);
		 $new_staffid = mysqli_real_escape_string($conn, $_POST['txtstaffid']);
		 $new_phone = mysqli_real_escape_string($conn, $_POST['txtphone']);
		 $new_email = mysqli_real_escape_string($conn, $_POST['txtemail']);
		 $sqlupdate = "UPDATE tutor SET Name='$new_name', StaffId='$new_staffid', phone='$new_phone', email='$new_email' WHERE sn='$new_sn'";
		 // die(var_dump($sqlupdate));
		 $result_update = mysqli_query($conn, $sqlupdate);
		 // die(var_dump($result_update));
		 if($result_update){
		 	echo '<script>window.location.href="newTutor.php"</script>';
		 }
		else{
			echo '<script>alert("Update failed")</script>';
		}
	}

//Delete
if(isset($_GET['delete'])){
	$sn = $_GET['delete'];
	$sqldelete = "DELETE FROM tutor WHERE sn='$sn'";
	$result_delete = mysqli_query($conn, $sqldelete);
	if($result_delete){
		echo '<script>window.location.href="newTutor.php"</script>';
	}
	else{
	echo '<script>alert("Data not deleted")</script>';	
	}
}
?>