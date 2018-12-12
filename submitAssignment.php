<?php 
// Submitting and assignment by accepting a jquery request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (!empty($_POST['submit'])) {

		if (isset($_POST['answer'])) {
		    	$answer = $_POST['answer'];
		    	$assId = $_POST['subAssId']; 
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
			      echo "Data Inserted Successfully";
			      ?>
			      <?php
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
		
	}
	else{
		echo "Select File to upload";
	}
	
}
?>