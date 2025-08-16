<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "hms_ite311";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn){
    echo "Connection unsucessful!";
}

?>
