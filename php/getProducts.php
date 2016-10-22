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


$query = "Select * FROM `products`";
$result = mysqli_query($conn,$query);

while($r=mysqli_fetch_object($result)) {
    $res[]=$r;
}

echo json_encode($res);


$conn->close();

?>