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


$updatePassword = "UPDATE accounts SET password = '".$data->newPassword."' WHERE username = '".$data->username."' AND email = '".$data->email."'";
$result = $conn->query($updatePassword);
echo 1;

$conn->close();

?>