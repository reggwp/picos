<?php
  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "picos";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// $res = array();

// $query = "Select * FROM `orders` ORDER BY timeordered ASC LIMIT 20";


if ($_GET['name'] == 'All') {
	$query = "Select * FROM `orders`";
	$msg = "No results";
}
else if ($_GET['name'] == 'Active') {
	$query = "Select * FROM `orders` WHERE status = 'Active'";
	$msg = "No results for active orders";
}
else if ($_GET['name'] == 'Completed') {
	$query = "Select * FROM `orders` WHERE status = 'Completed'";
	$msg = "No results for completed orders";	
}
else if ($_GET['name'] == 'Returned') {
	$query = "Select * FROM `orders` WHERE status = 'Returned'";
	$msg = "No results for returned orders";	
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