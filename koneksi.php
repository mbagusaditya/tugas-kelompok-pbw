<<<<<<< HEAD
<?php
date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$db = "alif";

//create connection
$conn = new mysqli($servername, $username, $password, $db);

//check connection
if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error);
}

//echo "Connected successfully<hr>";

?>
=======
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
>>>>>>> 57919dee0636b493801ef5d1e6b7fb58cd4d2537
