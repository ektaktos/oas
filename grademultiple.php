<?php 
	require_once('Admin/connect.php');
	if (isset($_POST['score'])) {

		$assId = $_POST['assId'];
        $arr = explode('_', $assId);
        $ass_Id = $arr[1];

        $courseCode = $_POST['course'];
        $matricNum = $_POST['matric'];
        $score = $_POST['score'];
        $subAssId = $_POST['subAssId'];

    	// Saving the assignment in database
    	// Checking if the result has been computed before
    	$select = "SELECT* FROM assignmentresult WHERE matricNum = '$matricNum' AND courseCode = '$courseCode'";
    	$resultSelect = $conn->query($select);
    	if ($resultSelect->num_rows < 1) {
    		$stmt = $conn->prepare("INSERT INTO assignmentresult(courseCode,matricNum,".$ass_Id.") VALUES (?,?,?)");
	    	$stmt->bind_param("sss",$courseCode,$matricNum,$score);
	    	$stmt->execute();
    	}else{
    		while ($row = $resultSelect->fetch_assoc()) {
    			$init_score = $row[''.$ass_Id.''];
    		}
    		$newscore = $score + $init_score;
    		// Updating the assignmentresult table
          $updateScore = "UPDATE assignmentresult SET ".$ass_Id." = '$newscore' WHERE matricNum = '$matricNum' AND courseCode = '$courseCode'";
       	  $resultScore = $conn->query($updateScore);
    	}

		 // Updating the assignmentsubmission table
          $updateSubmisssion = "UPDATE assignmentsubmission SET status = 'Graded' WHERE sub_AssId='$subAssId' AND matricNum='$matricNum'";
          $resultSubmission = $conn->query($updateSubmisssion);

		    if($resultSubmission === TRUE){
		     	echo "Student score saved";
		    }
		    else{
          
		      echo "Student score not saved " . $stmt->error;
		    }
	}
		
?>