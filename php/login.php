<?php

// NOTES
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


$compareEmail = "SELECT username, firstname, lastname, contact, location, email, isAdmin FROM accounts WHERE username = '".$data->username."' AND password = '".$data->password."'";
$result = $conn->query($compareEmail);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
}
else {
    echo 2;
}

$conn->close();

?>