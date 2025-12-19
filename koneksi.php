<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$db = "my_pbw";

//create connection
$conn = new mysqli($servername,$username,$password,$db);

//check connection
if($conn->connect_error){
	die("Connection failed : ".$conn->connect_error);
}

//echo "Connected successfully<hr>";
?>
