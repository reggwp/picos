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

$content = addslashes($data->products);
$orders = "INSERT INTO reservations (name, contact, occasiontype, occasionname, persons, arrivaldate, arrivaltime, datereserved, requests, food, status)
			VALUES ('$data->name', '$data->contact', '$data->occasionType', '$data->occasionName', '$data->persons', '$data->date', '$data->time', '$data->dateReserved', '$data->request', '$content', '$data->status')";
$result = mysqli_query($conn, $orders);

foreach ($data->cleanProducts as $order) {
	$updateSold = "UPDATE products SET sold = sold + $order->reservedQuantity WHERE id = '$order->id'";
	$resultSold = mysqli_query($conn, $updateSold);
}

echo $result;

$conn->close();

?>
