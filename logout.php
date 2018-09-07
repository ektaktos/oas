<?php
session_start();


if(!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos']))
{
	unset($_SESSION['oas_tutorId']);
	unset($_SESSION['oas_tutorpos']);
	unset($_SESSION['assID']);
	unset($_SESSION['matric']);
	?>
	<script type="text/javascript">
					window.location='index.php';
	</script>
	 <?php	

}
elseif(!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])){
	unset($_SESSION['oas_studmatricNum']);
	unset($_SESSION['oas_studpos']);
	unset($_SESSION['assID']);
	?>
	<script type="text/javascript">
					window.location='index.php';
	</script>
	 <?php	
}


else{
?>
<script type="text/javascript">
				alert("You cannot log out because you are not logged in")
				window.location='index.php';
</script>
 <?php
}
?>