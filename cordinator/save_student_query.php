<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_student'])){
		$MatricNum = $_POST['MatricNum'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$courses = $_POST['courses'];
		$password = md5($_POST['password']);
		$courses_json = json_encode($courses);
		$Name = $firstname . ' ' . $lastname;

		$qstudent = $conn->query("SELECT * FROM `student` WHERE `MatricNum` = '$MatricNum'") or die(mysqli_error());
		// die(var_dump($qstudent));
		$vstudent = $qstudent->num_rows;
		if($vstudent['student_no'] == 1){
			echo '
				<script type = "text/javascript">
					alert("Matric Number already exist");
					window.location = "student.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO student(MatricNum, Name, phone, email, courses, password) VALUES('$MatricNum', '$Name', '$phone', '$email', '$courses_json', '$password')") or die(mysqli_error());
			echo'
				<script type = "text/javascript">
					alert("Successfully saved data");
					window.location = "student.php";
				</script>
			';
		}
	}