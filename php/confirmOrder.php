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

$content = addslashes($data->orders);
$orders = "INSERT INTO orders (orders, referrer, name, contact, location, timedesired, timeordered, amount, grandtotal, status) VALUES ('$content', '$data->referrer', '$data->name', '$data->contact', '$data->location', '$data->desiredTime', '$data->datetimeOfOrder', '$data->money', '$data->grandtotal', '$data->status')";
$result = mysqli_query($conn, $orders);

foreach ($data->cleanOrders as $order) {
	$updateSold = "UPDATE products SET sold = sold + $order->inCart WHERE name = '$order->name'";
	$resultSold = mysqli_query($conn, $updateSold);
}

echo $result;

$conn->close();

?>
