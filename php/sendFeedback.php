<?php

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

$feedback = "INSERT INTO feedback (username, content, time, isViewed) VALUES ('".$data->username."', '".$data->content."', NOW(), 0)";
$result = $conn->query($feedback);
echo $result;


$conn->close();

?>
