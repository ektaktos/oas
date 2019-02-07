<?php 
	require_once('Admin/connect.php');
	if (isset($_POST['answer'])) {
	    	$answer = $_POST['answer'];
	    	$assId = $_POST['subAssId']; 
	    	$assignmentId = $_POST['assId'];
	    	$courseCode = $_POST['course'];
	    	$matricNum = $_POST['matric'];
	    	$status = "UnGraded";
	    	$date = date("Y-m-d H:i:s");
	    	$stmt = $conn->prepare("INSERT INTO assignmentsubmission(assignmentId,sub_AssId,courseCode,matricNum,ass_answer,status,date) VALUES (?,?,?,?,?,?,?)");
		    $stmt->bind_param("sssssss",$assignmentId,$assId,$courseCode,$matricNum,$answer,$status,$date);

		    if($stmt->execute()){
		      echo "Data Inserted Successfully";
		    }
		    else{
		      echo "Data not Successfully Inserted " . $stmt->error;
		    }
	}
		
?>