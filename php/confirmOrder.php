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
$name = addslashes($data->name);
$location = addslashes($data->location);
$delivery_location = addslashes($data->delivery_location);

// var_dump($name);
// echo "<hr/>";
// var_dump($location);
// echo "<hr/>";
// var_dump($delivery_location);

$orders = "INSERT INTO orders (orders, referrer, name, contact, location, delivery_location, type, timedesired, timeordered, amount, grandtotal, status, isViewed) VALUES ('$content', '$data->referrer', '$name', '$data->contact', '$location', '$delivery_location', '$data->type', '$data->desiredTime', '$data->datetimeOfOrder', '$data->money', '$data->grandtotal', '$data->status', 0)";
$result = mysqli_query($conn, $orders);

foreach ($data->cleanOrders as $order) {
	$updateSold = "UPDATE products SET sold = sold + $order->inCart WHERE name = '$order->name'";
	$resultSold = mysqli_query($conn, $updateSold);
}

echo $result;

$conn->close();

?>
