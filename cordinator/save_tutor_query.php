<?php
$conn = mysqli_connect("localhost", "root", "password", "oas");

	if(ISSET($_POST['save_tutor'])){
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$StaffId = $_POST['staffId'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$courses = $_POST['courses'];
		$password = md5($_POST['password']);
		$name = $firstname . ' ' . $lastname;
		$courses_json = json_encode($courses);
		$sqlsave = $conn->query("SELECT * FROM `tutor` WHERE `StaffId` = '$StaffId'") or die(mysqli_error());
		$result_save = $sqlsave->num_rows;
		if($result_save == 1){
			echo '
				<script type = "text/javascript">
					alert("Staff ID already taken");
					window.location = "newTutor.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO tutor(Name, StaffId, courses, phone, email, password) VALUES('$name', '$StaffId', '$courses_json', '$phone', '$email', '$password')") or die(mysqli_error());
			echo '
				<script type = "text/javascript">
					alert("Successfully saved data");
					window.location = "newTutor.php";
				</script>
			';
		}
	}
?>