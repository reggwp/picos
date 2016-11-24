<?php

// NOTES
// 1 - successfull
// 2 - something went wrong
// 3 - duplicate

$data = json_decode(file_get_contents("php://input"));
// var_dump($data);

  
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


$compareName = "SELECT * FROM products WHERE name = '".$data->name."'";
$result = mysqli_query($conn, $compareName);

if ($result->fetch_assoc()["name"] !== NULL) {
  echo 3;
}
else {
  $sql = "INSERT INTO products (name, description, serving, price, sold, image, dateupdated) VALUES ('".$data->name."', '".$data->description."', '".$data->serving."','".$data->price."','".$data->sold."', '".$data->image."', '".$data->dateupdated."')";
  $result = mysqli_query($conn, $sql);

  echo 1;
}

$conn->close();

?>
