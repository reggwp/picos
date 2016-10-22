<?php

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

$getPassword = "DELETE FROM products WHERE id = '".$_GET['id']."' AND name = '".$_GET['name']."'";
$result = $conn->query($getPassword);
echo $result;

$conn->close();

?>