<?php  
# creating connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "schPro_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
	die ("Connection Failed". $conn->connect_error);
}
?>