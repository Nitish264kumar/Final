<?php
$servername = "sql204.infinityfree.com";  // Replace with your actual InfinityFree DB hostname
$username = "if0_39535260";       // Replace with your InfinityFree DB username
$password = "QC3PwBaWwuBFBs";    // Replace with your DB password
$database = "if0_39535260_workdekho"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>