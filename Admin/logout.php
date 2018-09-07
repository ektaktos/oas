<?php
session_start();


if(!empty($_SESSION['oas_adminuser']) && !empty($_SESSION['oas_adminpos']))
{
	unset($_SESSION['oas_adminuser']);
	unset($_SESSION['oas_adminpos']);
	?>
	<script type="text/javascript">
					alert("Tutor Successfully logged out")
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