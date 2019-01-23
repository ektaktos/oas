<?php
//coursereg.php
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');
$column = array("courseCode", "courseName", "unit", "level", "semester");

$query = "SELECT * FROM course";

// Search
if(isset($_POST["search"]["value"]))
{
	$query .= '
	WHERE courseCode LIKE "%'.$_POST["search"]["value"].'%"
	OR courseName LIKE "%'.$_POST["search"]["value"].'%" 
	OR unit LIKE "%'.$_POST["search"]["value"].'%" 
	OR level LIKE "%'.$_POST["search"]["value"].'%"
	OR semester LIKE "%'.$_POST["search"]["value"].'%"';
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
	$sub_array[] =  '<div contenteditable class="update" data-id="'.$row["sn"].'" data-column="courseCode">' . $row["courseCode"] . '</
					div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["sn"].'" data-column="courseName">' . $row["courseName"] . '</div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["sn"].'" data-column="unit">' . $row["unit"] . '</div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["sn"].'" data-column="level">' . $row["level"] . '</div>';
	$sub_array[] = '<div contenteditable class="update" data-id="'.$row["sn"].'" data-column="semester">' . $row["semester"] . '</div>';
	$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["sn"].'">Delete</button>';
	$data[] = $sub_array;
}
function get_all_data($conn)
{
	$query = "SELECT * FROM course";
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
