<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_student'])){
		$MatricNum = $_POST['MatricNum'];
		$Name = $_POST['name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$qstudent = $conn->query("SELECT * FROM `student` WHERE `MatricNum` = '$MatricNum'") or die(mysqli_error());
		$vstudent = $qstudent->num_rows;
		if($vstudent['MatricNum'] == 1){
			echo '
				<script type = "text/javascript">
					alert("Matric Number already exist");
					window.location = "student.php";
				</script>
			';
		}else{
			$conn->query("UPDATE `student` SET `MatricNum` = '$MatricNum', `Name` = '$Name', `phone` = '$phone',  `email` = '$email' WHERE `MatricNum` = '$_REQUEST[MatricNum]'") or die(mysqli_error());
			echo'
				<script type = "text/javascript">
					alert("Save Changes");
					window.location = "student.php";
				</script>
			';
		}
	}	