<?php require 'connect.php'; ?>
<?php require_once 'valid.php'; ?>

<!DOCTYPE html>
<html lang = "eng">
	<head>
		<title>ASG System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content = "width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css"/>
		 <link href="assets/css/bootstrap.css" rel="stylesheet">
		 <!-- <link href="../Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
	</head>
	<body style = "background-color:#d3d3d3;">
		<?php include 'navigation.php'; ?>
<div class = "col-lg-10 well" style="background: white; position:relative; left:8%;">
	<div id="wrapper" class="wrapper" style = "margin-top:30px;">
		<div class = "alert alert-info" style="text-align:center; font-size:20px;">Insertion/Course</div>
			<div class = "col-lg-1"></div>
					<div class="table_responsive">
						<div align="right">
							<button type="button" name="add" id="add" class="btn btn-info">Add</button>
						</div>
						<br />
						<div id="alert_message"></div>
						<table id="course_data" class ="table table-bordered table-striped">
							<thead class ="alert-success">
								<tr>
									<th>Course Code</th>
									<th>Course name</th>
									<th>Course Unit</th>
									<th>Level</th>
									<th>Semester</th>
									<th>Action</th>
								</tr>
							</thead>
							
						</table>
					</div>
			</div>
</div>
		<br />
		<br />
		<br />
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

	<script type="text/javascript">

$(document).ready(function(){

	fetch_data();
	
	 function fetch_data()
	 {
	 	var dataTable = $('#course_data').DataTable({
	 	"processing": true,
	 	"serverSide": true,
	 	"order":[],
	 	"ajax":{
	 		url:"coursereg.php",
	 		type:"POST"
	 	}

	 	});
	}

	$('#add').click(function(){
		var html = '<tr>';
		html += '<td contenteditable id="data1"></td>';
		html += '<td contenteditable id="data2"></td>';
		html += '<td contenteditable id="data3"></td>';
		html += '<td contenteditable id="data4"></td>';
		html += '<td contenteditable id="data5"></td>';
		html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
		html += '</tr>';
		$('#course_data tbody').prepend(html);
	});

	$(document).on('click', '#insert', function(){
		var courseCode = $('#data1').text();
		var courseName = $('#data2').text();
		var unit = $('#data3').text();
		var level = $('#data4').text();
		var semester = $('#data5').text();
		if(courseCode != '' && courseName != '' && unit != '' && level != '' && semester != '')
		{
			$.ajax({
				url: "insert.php",
				method: "POST",
				data:{courseCode:courseCode, courseName:courseName, unit:unit, level:level, semester:semester},
				success:function(data)
				{
					$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#course_data').DataTable().destroy();
						fetch_data();
				}
			});
			setInterval(function(){
				$('#alert_message').html('');
			}, 5000);
		}
		else
		{
			alert("Both Fields is required");
		}
	});

	$(document).on("blur", ".update", function(){
		var sn = $(this).data("id");
		var column_name = $(this).data("column");
		var value = $(this).text();
		$.ajax({
			url:"update.php",
			method:"POST",
			data:{sn:sn, column_name:column_name, value:value},
			success:function(data)
			{
				$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
				$('#course_data').DataTable().destroy();
				fetch_data();
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var sn = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{sn:sn},
				success:function(data)
				{
					$('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
					$('#course_data').DataTable().destroy();
					fetch_data();
				}
			})
		}
	});
});
</script>	

</html>
