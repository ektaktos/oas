<?php
session_start();

if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
  # What to perform if the student is really logged in
require_once '../cordinator/connect.php';
$matricNum = $_SESSION['oas_studmatricNum'];
}

?>

<!DOCTYPE html>
<html lang = "eng">
	<head>
		<title>ASG System</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<link href="../Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel = "stylesheet" type = "text/css" href = "../cordinator/assets/css/chosen.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "../cordinator/assets/css/jquery.dataTables.css" />
		 <!-- Custom fonts for this template-->
    <link href="../Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../Admin/dashboard/css/sb-admin.css" rel="stylesheet">

	</head>
	<body style="background:#e2e0e1;">
		<!-- Navigation Bar -->
		<?php include 'navigation.php'; ?>

		<div id="wrapper">
			<!-- Sidebar -->
      <?php include 'sidebar.php'; ?>

		<div id="content-wrapper">
		<div class = "container-fluid">
			<?php
			
				$q_student = $conn->query("SELECT * FROM student WHERE MatricNum='$matricNum'");
				// die(var_dump($_SESSION['oas_studmatricNum']));
				while($r_student=$q_student->fetch_array())
				{
					$ccode = str_replace('_', ' ', $r_student['courses']);
				}//End while
			?>
			<?php if (!empty($ccode)) { ?>
	          <div style="text-align:center;font-size: 18px;background:white;">
	            <span style="color:black;"><b>Registered Courses:</b> <?= implode(", ", str_replace('_',' ', json_decode($ccode)));?>.
	          </div>
	          <?php }else{?>
	            	<div style="text-align: center; margin-bottom: 20px; font-size: 18px;">
	            		<span><b>Registered Courses:</b> </span> No Course registered yet.
	          		</div>
          	<?php } //End if and else Statement ?> 
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:60px; position:relative;left:9%;background:white;">
				<div class = "alert alert-info">Registration / Course</div>

				<!-- Form for Submitting Courses Registered -->
				<form method = "POST" action = "save_course_query.php" enctype = "multipart/form-data">
					<div class = "form-group pull-right">
						<button name = "save_course" class = "btn btn-primary"><span class = "glyphicon glyphicon-thumbs-up"></span> Register</button>
					</div>
					<table id = "table" class = "table table-bordered">
						<thead class = "alert-success">
							<tr>
								<th>Select</th>
								<th>course Code</th>
								<th>Course Name</th>
								<th>Unit</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$q_course = $conn->query("SELECT * FROM `course`") or die(mysqli_error());
								$rownum = $q_course->num_rows;
								while($f_course = $q_course->fetch_array()){
									$r_coursecode = str_replace('_', ' ', $f_course['courseCode']); //Replacing space in a string with underscore.
							?> 
							<tr>
								<td>
									<?php
										if($rownum < 1){
											echo "<center><label class = 'text-danger'>Not Available</label></center>";
										}else{
											echo '<input type = "checkbox" name = "course[]" value = "'.$f_course['courseCode'].'"></center>';
										}//End if and else statment
									?>
								</td>
								<td><?php echo $r_coursecode ?></td>
								<td><?php echo $f_course['courseName']?></td>
								<td><?php echo $f_course['unit']?></td>
							</tr>
							<?php
								}//End while
							?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
		<nav class = "navbar navbar-default navbar-fixed-bottom">
			<div class = "container-fluid">
				<label class = "navbar-text pull-right">Library System &copy; All rights reserved 2016</label>
			</div>
		</nav>
	</body>
	<script src = "../cordinator/assets/js/jquery.js"></script>
	<script src = "../cordinator/assets/js/bootstrap.js"></script>
	<!-- <script src = "js/login.js"></script>
	<script src = "js/sidebar.js"></script> -->
	<script src = "../cordinator/assets/js/jquery.dataTables.js"></script>
	<script src = "../cordinator/assets/js/chosen.jquery.min.js"></script>	
	<script type = "text/javascript">
		$(document).ready(function(){
			$("#student").chosen({ width:"auto" });	
		})
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$("#table").DataTable();
		});
	</script>
</html>