<?php
	require_once "Admin/connect.php";
	session_start();
	$date = date("Y-m-d h:i:sa");
	
	// Saving the assignment id in a session variable and allowing a new id to override
	if (!empty($_GET['Id'])){
		$assignmentId = $_GET['Id'];
		$_SESSION['assID'] = $assignmentId;
	}
	else{
		$assignmentId = $_SESSION['assID'];
	}

	$matricNum = $_SESSION['oas_studmatricNum'];

	$queryStudent = "SELECT Name FROM student WHERE MatricNum = '$matricNum'";
	$resultStudent = $conn->query($queryStudent);

 	while ($row = $resultStudent->fetch_assoc()) {
        $studentName = $row['Name'];
    }


?>
<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="image/alphatim.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>Submit Assignment - Online Assignment Submission</title>
<!-- Bootstrap core CSS -->
<link href="admin/css/bootstrap.min.css" rel="stylesheet">
<link href="admin/css/dashboard.css" rel="stylesheet">

<body>

<div class="jumbotron">
      <div class="container" align="center">
      <h1 align="center">Online Assignment Submission</h1>
      <p align="center">Upload Assignment File</p>
      </div>
 </div><!-- End of Main Jumbotron-->

 <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
      <button type="button" class="navbar-toggler hidden-sm-up" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="student.php">Home</a>
      <div id="navbar">
        
        <span class="pull-xs-right">
          <P>Welcome here, <?php echo $studentName; ?></P>
        </span>
      </div>
    </nav>	
<div class="container assDetails">
<!-- This is the page where the student gets to upload the solution to a given assignment -->
<?php	


	// Getting all the details of the assignment from database
	$selectDetails = "SELECT* FROM assignmentdetails WHERE assignmentId = '$assignmentId'";
	$resultDetails = $conn->query($selectDetails);
	$rownum = $resultDetails->num_rows;

	// Getting the details of the tutor from database too

	if ($rownum > 0 ) {
		# What to perform when the assignment Id is present in database
		while ($row = $resultDetails->fetch_assoc()) {

			$question = $row['assignmentQuestion'];
			$tutor = $row['tutor'];
			$tutorId = $row['tutorId'];
			$courseCode = $row['courseCode'];
			$submDate = $row['submissionDate'];
			$dateAssigned = date("M j, Y",strtotime($row['dateAssigned']));
			$deadlineDate = date("M j, Y",strtotime($row['submissionDate']));
			$deadlineTime = date("h:ia",strtotime($row['submissionDate']));
			$assignedScore = $row['score'];
			$filePath = $row['file_path'];
			$arr = explode('/', $filePath);
	        $ass_file = $arr[1];
		}
			
		// Getting the details of the tutor from database too
		$selectTutor = "SELECT* FROM tutor WHERE StaffId = '$tutorId'";
		$resultTutor = $conn->query($selectTutor);

		while ($row = $resultTutor->fetch_assoc()) {
			$tutorEmail = $row['email'];
			$tutorPhone = $row['phone'];
		}
		echo "<table class='table table-bordered'>";
		echo "<tr><td><strong>Assignment Question:</strong></td><td> ". $question."</td></tr>";
		if ($filePath == "") {
			
		}
		else{
		echo "<tr><td><strong>Assignment File:</strong></td><td><a target='_blank' href='".$filePath."'>".$ass_file."</a></td></tr>";
		}
		echo "<tr><td><strong>Assignment Id:</strong></td><td> " . $assignmentId ."</td></tr>";
		echo "<tr><td><strong>Tutor Name:</strong></td><td> " . $tutor ."</td></tr>";
		echo "<tr><td><strong>Tutor Email:</strong></td><td> " . $tutorEmail ."</td></tr>";
		echo "<tr><td><strong>Tutor Phone:</strong></td><td> " . $tutorPhone ."</td></tr>";
		echo "<tr><td><strong>Course Code:</strong></td><td> " . $courseCode ."</td></tr>";
		echo "<tr><td><strong>Date Assigned:</strong></td><td> " . $dateAssigned ."</td></tr>";
		echo "<tr><td><strong>Submission Date:</strong></td><td> " . $deadlineDate ."</td></tr>";
		echo "<tr><td><strong>Submission Time:</strong></td><td> " . $deadlineTime ."</td></tr>";
		echo "<tr><td><strong>Assigned Score:</strong></td><td> " . $assignedScore ."</td></tr>";
		echo "</table>";
		$status = "UnGraded";

		// Checking if the submission deadline has not passed
		$datetime1 = new DateTime($submDate);
		$datetime2 = new DateTime(date("Y-m-d h:i:sa"));

		if ($datetime2 > $datetime1) {
			echo "<b>Sorry, Assignment cannot be Submitted. Submission Deadline has been reached.</b>";
		}
		else{
		?>
		<!-- Form To upload the txt document-->
		<form method="post" role="form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="file" name="myfile">
			<input type="submit" name="submit" value="Upload" class="btn btn-primary">
		</form>

		<?php
		}

	}
	else{
		echo "Sorry, Assignment Does not Exist";
	}
	
// Validating that a POST request was sent and the action to perform
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (!empty($_POST['submit'])) {

		$target_dir = "sub_ass_files/";
		$target_file = $target_dir . basename($_FILES["myfile"]["name"]);

		$uploadOk = 1;
		$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["myfile"]["size"] > 5000000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($FileType != "txt" && $FileType != "doc" && $FileType != "pdf") {
		    echo "Only txt, doc and pdf files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} 
		else {

		    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)){

		        // echo "File Successfully uploaded.";

		        // Saving the assignment in database
		        $stmt = $conn->prepare("INSERT INTO assignmentsubmission(assignmentId,courseCode,matricNum,ass_file_path,status,date) VALUES (?,?,?,?,?,?)");
			    $stmt->bind_param("ssssss",$assignmentId,$courseCode,$matricNum,$target_file,$status,$date);

			    if($stmt->execute()){
			      echo "Data Inserted Successfully";
			    }
			    else{
			      echo "Data not Successfully Inserted " . $stmt->error;
			    }
		    } 
		    else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
		
	}
	else{
		echo "Select File to upload";
	}
	
}



// }
// else{
// 	echo "Sorry this page is inaccessible";
// }


?>
</div>

<div class="container-fluid col-sm-12">
    <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Alphatim Inc. </p>
      </footer>
</div>

</body>