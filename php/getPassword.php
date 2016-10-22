<?php

// NOTES
// 2 - account not found

// $data = json_decode(file_get_contents("php://input"));
  
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


$getPassword = "SELECT password FROM accounts WHERE username = '".$_GET['username']."' AND email = '".$_GET['email']."'";
$result = $conn->query($getPassword);

if ($result->num_rows > 0) {
	echo json_encode($result->fetch_assoc());
}
else {
    echo 2;
}

// $conn->close();

?>