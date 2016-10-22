<?php

// NOTES
// 1 - successful
// 2 - account not found

$data = json_decode(file_get_contents("php://input"));
  
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

$updateAccount = "UPDATE accounts
				  SET username='".$data->username."',
				  firstname = '".$data->firstname."',
				  lastname = '".$data->lastname."',
				  location = '".$data->location."',
				  contact = '".$data->contact."'

				  WHERE email='".$data->email."'";

$result = $conn->query($updateAccount);
echo 1;

$conn->close();

?>