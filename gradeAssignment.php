<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";

// Saving the assignment id in a session variable and allowing a new id to override
	if (!empty($_GET['Id']) && !empty($_GET['matric'])){
		$assignmentId = $_GET['Id'];
		$matricNum = $_GET['matric'];
		$_SESSION['assID'] = $assignmentId;
		$_SESSION['matric'] = $matricNum;
	}
	else{
		$assignmentId = $_SESSION['assID'];
		$matricNum = $_SESSION['matric'];
	}


if (!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos'])) {
 	 
    $tutorId = $_SESSION['oas_tutorId'];
    

    $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
	$resultTutor = $conn->query($queryTutor);

	$queryAssDetails = "SELECT assignmentQuestion,score FROM assignmentdetails WHERE assignmentId='$assignmentId'";
	$resultAssDetails = $conn->query($queryAssDetails);

 	// Mysql Query to select the details of assignments from database
	$selectAssignment = "SELECT* FROM assignmentsubmission WHERE assignmentId='$assignmentId' AND matricNum = '$matricNum'";
	$resultAssignment = $conn->query($selectAssignment); 

	// Checking if the assignment has been graded for the student already 
	$queryResult = "SELECT* FROM assignmentresult WHERE assignmentId = '$assignmentId' AND matricNum = '$matricNum'";
	$resultResult = $conn->query($queryResult);

    while ($row = $resultTutor->fetch_assoc()) {
        $tutorName = $row['Name'];
    }

    while ($row = $resultAssDetails->fetch_assoc()) {
    	$question = $row['assignmentQuestion'];
    	$exp_score = $row['score'];
    }
    
	while ($row = $resultAssignment->fetch_assoc()) {
        $courseCode = $row['courseCode'];
        $ass_path = $row['ass_file_path'];

        $arr = explode('/', $ass_path);
        $ass_file = $arr[1];
        $newpath = "graded_ass_files/".$ass_file;
     }

     while ($row = $resultResult->fetch_assoc()) {
     	$graded_score = $row['score'];
     }

 }

 else{
 	echo "Sorry You are not Authorized to view this page";
 	header("Location:index.php");
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
<title>Grade Assignment-Online Assignment Submission</title>
<!-- Bootstrap core CSS -->
<link href="admin/css/bootstrap.min.css" rel="stylesheet">

<body>

<div class="jumbotron">
      <div class="container" align="center">
      <h1 align="center">Online Assignment Submission</h1>
      <p align="center">Grade Assignment</p>
      </div>
 </div><!-- End of Main Jumbotron-->

 <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
      
        <span class="pull-xs-right">
          <P>Welcome here, <?php echo $tutorName; ?></P>
        </span>
    </nav>	

 <!-- Div container to contain the page -->
 <div class="container">

<div class="offset-md-2 col-md-8">
<p><strong>Course Name/Code:</strong> <?php echo $courseCode;  ?></p>
<p><strong>Assignment Title:</strong> <?php echo $question; ?></p>
<p><strong>Student Matric Number:</strong> <?php echo $matricNum; ?></p>

<P><strong>Assignment File:</strong> <a target="_blank" href="<?php echo $ass_path; ?>"><?php echo $ass_file; ?></a></P>

<p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>

	<?php
		if ($resultResult->num_rows > 0) {
			echo "<p><strong>Score: </strong>".$graded_score."/".$exp_score."</p>";

		}
	?>


<form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<div class="form-group">
		<?php
			if ($resultResult->num_rows > 0) {
				echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score' disabled>";	
			}
			elseif (!empty($_GET['Id']) && !empty($_GET['matric'])) {
				echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score'>";
			}
			else{
				echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score' disabled>";	
			}
		?>
	</div>

	<div class="col-sm-12" align="center">
	<input type="submit" value="Submit" name="submit" class="btn btn-primary">
	</div>

</form>
</div>
</div>

<div class="container-fluid col-sm-12">
    <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Alphatim Inc. </p>
      </footer>
</div>

</body> 

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!empty($_POST['Score'])) {

		$score = $_POST['Score'];
		$status = "Graded";
		echo "The Score is " .$score;

		// Renaming the name of the assignment file and folder
		$path = rename($ass_path, $newpath);

		// Checking if the assignment has been graded for the student already 
		$queryResult = "SELECT* FROM assignmentresult WHERE assignmentId = '$assignmentId' AND matricNum = '$matricNum'";
		$resultResult = $conn->query($queryResult);
		if ($resultResult->num_rows < 1) {
					
		 // Saving the assignment in database
	        $stmt = $conn->prepare("INSERT INTO assignmentresult(courseCode,assignmentId,matricNum,score) VALUES (?,?,?,?)");
		    $stmt->bind_param("ssss",$courseCode,$assignmentId,$matricNum,$score);

		 // Updating the assignmentsubmission table
		    $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status',ass_file_path = '$newpath' WHERE assignmentId='$assignmentId' AND matricNum='$matricNum'";
		    $resultSubmission = $conn->query($updateSubmisssion);

		    if($stmt->execute() && $resultSubmission === TRUE){
		      ?>
		      <script type="text/javascript">
		      	alert("Student Score Successfully Saved")
		      	window.location = "tutor.php";
		      </script>
		      <?php
		    }
		    else{
		      echo "Student score not saved " . $stmt->error;
		    }
		}
		else{
			echo "Sorry, Student result has been Saved Before.";
		}
	}
}

?>
