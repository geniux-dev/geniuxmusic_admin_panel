<?php
if (session_status() == PHP_SESSION_NONE) {session_start(); }

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "geniux";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}
?>