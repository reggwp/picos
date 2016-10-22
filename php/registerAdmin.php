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


$compareEmail = "SELECT * FROM accounts WHERE email = '".$data->email."'";
$result = $conn->query($compareEmail);
	

if ($result->fetch_assoc()["email"] !== NULL) {
  echo 3;
}
else {
  $createAdminRecord = "INSERT INTO accounts (username, firstname, lastname, location, contact, password, email, isAdmin)
  		VALUES ('".$data->username."', '".$data->firstname."', '".$data->lastname."','".$data->location."','".$data->contact."', '".$data->password."', '".$data->email."', 1)";

  if ($conn->query($createAdminRecord) === TRUE) {
	  echo 1;
  } else {
    echo 2;
  }

}

$conn->close();

?>
