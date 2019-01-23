<?php
session_start();


if(isset($_SESSION['oas_adminuser']))
{
	unset($_SESSION['oas_adminuser']);
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



<!-- session_start();
if(isset($_SESSION['matricNum'])){
	unset($_SESSION['matricNum']);
	header('location: ../index.php');
} -->