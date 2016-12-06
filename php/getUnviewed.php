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


$res1 = array();
$res2 = array();
$res3 = array();

$query1 = "Select isViewed FROM `feedback` WHERE isViewed = 0";
$result1 = mysqli_query($conn,$query1);
while($r1=mysqli_fetch_object($result1)) {
    $res1[]=$r1;
}

$query2 = "Select isViewed FROM `orders` WHERE isViewed = 0";
$result2 = mysqli_query($conn,$query2);
while($r2=mysqli_fetch_object($result2)) {
    $res2[]=$r2;
}

$query3 = "Select isViewed FROM `reservations` WHERE isViewed = 0";
$result3 = mysqli_query($conn,$query3);
while($r3=mysqli_fetch_object($result3)) {
    $res3[]=$r3;
}

$main = array(
    'feedbacks' => $res1,
    'orders' => $res2,
    'reservations' => $res3
);

echo json_encode($main);

$conn->close();

?>