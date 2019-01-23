<?php
//for display full info and edit data
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');

// var_dump($_REQUEST['id']);

if(isset($_REQUEST['id'])){
	$sn=intval(($_REQUEST['id']));
	$sql = "SELECT * FROM tutor WHERE sn=$sn";
	$run = mysqli_query($conn, $sql);
	while ($row=mysqli_fetch_array($run)) {
		$per_sn = $row["sn"];
		$per_name = $row["Name"];
		$per_staffid = $row["StaffId"];
		$per_phone = $row["phone"];
		$per_email = $row["email"];
		// $per_courses = $row["courses"];
	}//end while

	?>
	<form class="form-horizontal" method="post">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Information</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label class="col-sm-4 control-label for="txtsn">ID</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="txtsn" name="txtsn" value="<?php echo $per_sn ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label for="txtname">Full Name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $per_name ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label for="txtstaffid">Staff ID</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="txtstaffid" name="txtstaffid" value="<?php echo $per_staffid ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label for="txtphone">Phone</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="txtphone" name="txtphone" value="<?php echo $per_phone ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label for="txtemail">Email</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="txtemail" name="txtemail" value="<?php echo $per_email ?>">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="newTutor.php"><button type="button" class="btn btn-danger">Cancel</button></a>
				<button type="submit" class="btn btn-primary" name="btnEdit">Save</button>
			</div>
		</div>
	</form>
<?php
} //end if


?>