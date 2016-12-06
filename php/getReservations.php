<?php
  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "picos";

$data = json_decode(file_get_contents("php://input"));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


if ($data->isAdmin === 1) {

	if ($data->status->name === 'All') {
		$query = "Select * FROM `reservations`";
		$msg = "No results";
	}
	else if ($data->status->name === 'Reserved') {
		$query = "Select * FROM `reservations` WHERE status = 'Reserved'";
		$msg = "No results for reserved reservations";
	}
	else if ($data->status->name === 'Completed') {
		$query = "Select * FROM `reservations` WHERE status = 'Completed'";
		$msg = "No results for completed reservations";	
	}
	else if ($data->status->name === 'Cancelled') {
		$query = "Select * FROM `reservations` WHERE status = 'Cancelled'";
		$msg = "No results for cancelled reservations";	
	}

}
else {
	
	if ($data->status->name === 'All') {
		$query = "Select * FROM `reservations` WHERE email = '".$data->email."'";
		$msg = "No results";
	}
	else if ($data->status->name === 'Reserved') {
		$query = "Select * FROM `reservations` WHERE email = '".$data->email."' AND status = 'Reserved'";
		$msg = "No results for reserved reservations";
	}
	else if ($data->status->name === 'Completed') {
		$query = "Select * FROM `reservations` WHERE email = '".$data->email."' AND status = 'Completed'";
		$msg = "No results for completed reservations";	
	}
	else if ($data->status->name === 'Cancelled') {
		$query = "Select * FROM `reservations` WHERE email = '".$data->email."' AND status = 'Cancelled'";
		$msg = "No results for cancelled reservations";	
	}
}

$result = mysqli_query($conn,$query);


while($r=mysqli_fetch_object($result)) {
    $res[]=$r;
}

if (isset($res)) {
	echo json_encode($res);
}
else {
	echo $msg;
}



$conn->close();

?>