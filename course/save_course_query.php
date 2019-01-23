<?php
	require_once '../cordinator/connect.php';
	session_start();
if(!ISSET($_POST['course'])){
	echo '
			<script type = "text/javascript">
				alert("Select a course first!");
				window.location = "registerCourse.php";
			</script>
			';
}else{
		if($_POST['course']){
			$MatricNum = $_SESSION['oas_studmatricNum'];
			$course_list = $_POST['course'];
			$course_json = str_replace('', '_', json_encode($course_list));
			// die(var_dump($course_json, $MatricNum));
			$conn->query("UPDATE student SET courses='$course_json' WHERE matricNum='$MatricNum'") or die(mysqli_error());
			echo '
				<script type = "text/javascript">
					alert("Successfully Registered");
					window.location = "registerCourse.php";
				</script>
				';
			}
		}		