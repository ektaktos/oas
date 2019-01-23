		<table class="table" style="width: 70%; margin: 50px 0px 0px 50px">
			<?php
				if ($rownum > 0) {
					echo "<tr><td>Full Name: </td><td>" . $Name ."</td></tr>";
					echo "<tr><td>Matric Number: </td><td>" . $id ."</td></tr>";
					echo "<tr><td>Phone: </td><td>" . $phone ."</td></tr>";
					echo "<tr><td>Email: </td><td>" . $email ."</td></tr>";
				}
				else{
			echo "Profile not available";
				}
		?>

		</table>



