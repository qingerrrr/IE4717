<?php
$servername = "localhost";
$username = "f32ee";
$password = "f32ee";
$dbname = "dunot_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>