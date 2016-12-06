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

$query = "UPDATE orders
				  SET isViewed = 1
				  WHERE isViewed = 0";

$result1 = mysqli_query($conn, $query) or die(mysql_error());
echo 1;

$conn->close();

?>