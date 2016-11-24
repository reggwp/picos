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


$updateStatus = "UPDATE products SET isOutOfStock = '".$data->stock."' WHERE id = '".$data->id."'";
$result = mysqli_query($conn, $updateStatus);
echo 1;

$conn->close();

?>