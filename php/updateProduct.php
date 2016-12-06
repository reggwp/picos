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

$updateProduct = "UPDATE products
				  SET name = '".$data->name."',
				  description = '".$data->description."',
				  serving = '".$data->serving."',
				  price = '".$data->price."',
				  dateupdated = '".$data->datenow."',
				  image = '".$data->image."'
				  WHERE id = '".$data->id."'";
// $updateProduct = "UPDATE products SET name = '".$data->name."', description = '".$data->description."', serving = '".$data->serving."', price = '".$data->price."', image = '".$data->image."', dateupdated = NOW() WHERE id = '".$data->id."'";
$result = mysqli_query($conn, $updateProduct) or die(mysql_error());
echo 1;

$conn->close();

?>