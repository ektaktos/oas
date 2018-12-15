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

    $selectAssignment = "SELECT* FROM assignmentsubmission WHERE assignmentId='$assignmentId' AND matricNum = '$matricNum'";
	$resultAssignment = $conn->query($selectAssignment); 

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>Submit Assignment - ASG</title>
<!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
     <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">


<body>

<nav class="navbar navbar-light bg-dark">
  <a class="navbar-brand" href="student.php">
    <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
    <span style="color: white;">ASG System</span>
  </a>
  <span class="pull-xs-right" style="color: white;">
          <P>Welcome here, <?php echo $studentName; ?></P>
  </span>
</nav>

<div class="container assDetails">
	<div id="message" style="text-align: center; margin-top: 5px;"></div>
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
			$type = $row['type'];
			$question = $row['assignmentQuestion'];
			$tutor = $row['tutor'];
			$tutorId = $row['tutorId'];
			$courseCode = $row['courseCode'];
			$type = $row['type'];
			$submDate = $row['submissionDate'];
			$dateAssigned = date("M j, Y",strtotime($row['dateAssigned']));
			$deadlineDate = date("M j, Y",strtotime($row['submissionDate']));
			$deadlineTime = date("h:ia",strtotime($row['submissionDate']));
			$assignedScore = $row['score'];
			if(!empty($row['file_path'])){
			$filePath = $row['file_path'];
			$arr = explode('/', $filePath);
	        $ass_file = $arr[1];
	        }
		}
			
		// Getting the details of the tutor from database too
		$selectTutor = "SELECT* FROM tutor WHERE StaffId = '$tutorId'";
		$resultTutor = $conn->query($selectTutor);

		while ($row = $resultTutor->fetch_assoc()) {
			$tutorEmail = $row['email'];
			$tutorPhone = $row['phone'];
		}
		if ($type == 'single') {
		echo "<table class='table table-bordered'>";
		echo "<tr><td><strong>Assignment Question:</strong></td><td> ". $question."</td></tr>";
		if (isset($filePath) == "") {
		}
		else{
		echo "<tr><td><strong>Assignment File:</strong></td><td><a target='_blank' href='".$filePath."'>".$ass_file."</a></td></tr>";
		}
		echo "<tr><td><strong>Assignment Id:</strong></td><td> " . $assignmentId ."</td></tr>";
		echo "<tr><td><strong>Tutor Name:</strong></td><td> " . $tutor ."</td></tr>";
		echo "<tr><td><strong>Tutor Email:</strong></td><td> " . $tutorEmail ."</td></tr>";
		echo "<tr><td><strong>Tutor Phone:</strong></td><td> " . $tutorPhone ."</td></tr>";
		echo "<tr><td><strong>Course Code:</strong></td><td> " . str_replace('_',' ',$courseCode)."</td></tr>";
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
		elseif ($resultAssignment->num_rows > 0) {
			echo "<b>Assignment has been Submitted Already.</b>";
		}
		else{
		?>
		<!-- Form To upload the txt document-->
		<form method="post" role="form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type="file" name="myfile" required="">
			<input type="hidden" name="subAssId" value="">
			<input type="submit" name="submit" value="Upload" class="btn btn-primary">
		</form>
		<?php
		}

		}elseif($type == 'multiple'){
		echo "<table class='table table-bordered'>";
		echo "<tr><td><strong>Assignment Id:</strong></td><td> " . $assignmentId ."</td></tr>";
		echo "<tr><td><strong>Tutor Name:</strong></td><td> " . $tutor ."</td></tr>";
		echo "<tr><td><strong>Tutor Email:</strong></td><td> " . $tutorEmail ."</td></tr>";
		echo "<tr><td><strong>Tutor Phone:</strong></td><td> " . $tutorPhone ."</td></tr>";
		echo "<tr><td><strong>Course Code:</strong></td><td> " . str_replace('_',' ',$courseCode)."</td></tr>";
		echo "<tr><td><strong>Date Assigned:</strong></td><td> " . $dateAssigned ."</td></tr>";
		echo "<tr><td><strong>Submission Date:</strong></td><td> " . $deadlineDate ."</td></tr>";
		echo "<tr><td><strong>Submission Time:</strong></td><td> " . $deadlineTime ."</td></tr>";
		echo "</table>";
		$status = "UnGraded";
		// Checking if the submission deadline has not passed
		$datetime1 = new DateTime($submDate);
		$datetime2 = new DateTime(date("Y-m-d h:i:sa"));

		if ($datetime2 > $datetime1) {
			echo "<b>Sorry, Assignment cannot be Submitted. Submission Deadline has been reached.</b>";
		}
		elseif ($resultAssignment->num_rows > 4) {
			echo "<b>Assignment has been Submitted Already.</b>";
		}
		else{
			// Getting assignments that have been submitted from database
            $querySelect1 = "SELECT* FROM assignmentsubmission WHERE matricNum='$matricNum' AND courseCode='$courseCode'";
            $resultSelect1 = $conn->query($querySelect1);
            if ($resultSelect1->num_rows > 0) {
            	while ($row2 = $resultSelect1->fetch_assoc()) {
		        $assIdArray[] = $row2['sub_AssId'];
		        }
		        $assignments_string = implode("','", $assIdArray);
            }else{
            	$assignments_string = '';
            }

            $selectQuestion = "SELECT* FROM assignmentdetails WHERE assignmentId = '$assignmentId' AND sub_AssId NOT IN ('$assignments_string')";
            $resultQuestion = $conn->query($selectQuestion);
            $rownum = $resultQuestion->num_rows;  $i = 0; $j=1;
            while ($row1 = $resultQuestion->fetch_assoc()) {
            	?>
			<form method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="row">
			 <div class="col-sm-4"><b>Question <?=$j?>:</b> <?=$row1['assignmentQuestion']?></div>
			 <div class="col-sm-4">
			 <textarea class="form-control" name="answer" Placeholder="Enter the Answer Here" rows="5" cols="10"></textarea>
			 </div>
			 <input type="hidden" name="subAssId" value="<?=$row1['sub_AssId']?>">
			 <div class="col-sm-2">
			 	<input type="submit" name="submit" value="Submit" class="btn btn-primary">
			 </div>
			 <div class="col-sm-2"><b>Assigned Score:</b> <?=$row1['score']?></div>
			 </div>
			</form>
			<?php $j+=1;}
		}
		}
		
	}
	else{
		echo "Sorry, Assignment Does not Exist";
	}
	
// Validating that a POST request was sent and the action to perform
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (!empty($_POST['submit'])) {

		if (isset($_POST['answer'])) {
		    	$answer = $_POST['answer'];
		    	$assId = $_POST['subAssId']; 
		    	// echo $assId;
		    	$stmt = $conn->prepare("INSERT INTO assignmentsubmission(assignmentId,sub_AssId,courseCode,matricNum,ass_answer,status,date) VALUES (?,?,?,?,?,?,?)");
			    $stmt->bind_param("sssssss",$assignmentId,$assId,$courseCode,$matricNum,$answer,$status,$date);

			    if($stmt->execute()){
			      echo "Data Inserted Successfully";
			      header("Location:upload.php?Id=".$_GET['Id']."");
			    }
			    else{
			      echo "Data not Successfully Inserted " . $stmt->error;
			    }
		}
		elseif(!empty($_FILES["myfile"]["tmp_name"])){

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

		        $stmt = $conn->prepare("INSERT INTO assignmentsubmission(assignmentId,courseCode,matricNum,ass_file_path,status,date) VALUES (?,?,?,?,?,?)");
			    $stmt->bind_param("ssssss",$assignmentId,$courseCode,$matricNum,$target_file,$status,$date);

			    if($stmt->execute()){
			      	?>
				     <script>
				      alert("Assignment Submitted successfully");
				     window.location.href = 'student.php';
				     </script>
				     <?php
			    }
			    else{
			    	?>
		      <script>
		          document.getElementById("message").innerHTML = "Assignment not Submitted";
		          document.getElementById("message").style.color = "red";
		      </script>
		      <?php
			      // echo "Data not Successfully Inserted " . $stmt->error;
			    }
		    } 
		    else {
		    	?>
		      <script>
		          document.getElementById("message").innerHTML = "Sorry, There was an error uploading your file.";
		          document.getElementById("message").style.color = "red";
		      </script>
		      <?php
		        // echo "Sorry, there was an error uploading your file.";
		    }
		}
	}	
	}
	else{
		?>
		      <script>
		          document.getElementById("message").innerHTML = "Select File to upload.";
		          document.getElementById("message").style.color = "red";
		      </script>
		      <?php
		echo "Select File to upload";
	}
	
}


?>
</div>

<!-- Sticky Footer -->
        <footer class="sticky-footer container-fluid">
          <div class="container my-auto">
            <div class="copyright my-auto">
              <span>Assignment Submission & Grading System &copy; All rights reserved <?=date('Y')?></span>
            </div>
          </div>
        </footer>


</body>