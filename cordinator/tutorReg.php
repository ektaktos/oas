<?php
//coursereg.php
session_start();
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');

$column = array("sn", "Name", "StaffId", "phone", "email", "courses");

$query = "SELECT * FROM tutor";

// Search
if(isset($_POST["search"]["value"]))
{
	$query .= '
	WHERE sn LIKE "%'.$_POST["search"]["value"].'%"
	OR Name LIKE "%'.$_POST["search"]["value"].'%" 
	OR StaffId LIKE "%'.$_POST["search"]["value"].'%" 
	OR phone LIKE "%'.$_POST["search"]["value"].'%"
	OR email LIKE "%'.$_POST["search"]["value"].'%"
	OR courses LIKE "%'.$_POST["search"]["value"].'%"';
}

//Order
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
	';
}
else
{
	$query .= 'ORDER BY sn DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
	$query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));
$result = mysqli_query($conn, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{

	$sub_array = array();
	$sub_array[] = $row["sn"];
	$sub_array[] = $row["Name"];
	$sub_array[] = $row["StaffId"];
	$sub_array[] = $row["phone"];
	$sub_array[] = $row["email"];
	$sub_array[] = json_decode($row['courses']);
	$sub_array[] = '<button type="button" name="edit" id="getEdit" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$row["sn"].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Edit</button>
		<a href="newTutor.php?delete='.$row["sn"].'" onclick="return confirm(\'Are You sure? \')" name="delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash">&nbsp;</i>Delete</a>';
	$data[] = $sub_array;
}
function get_all_data($conn)
{
	$query = "SELECT * FROM tutor";
	$result = mysqli_query($conn, $query);
	return mysqli_num_rows($result);
}

$output = array(
	"draw" 				=> intval($_POST["draw"]),
	"recordsTotal" 		=> get_all_data($conn),
	"recordsFiltered" 	=> $number_filter_row,
	"data"				=> $data
);

echo json_encode($output);

?>
