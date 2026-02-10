<?php
// engine/db_connect.php

// Use environment variables for production (Railway) or local fallbacks
$host = getenv("MYSQLHOST") ?: "localhost";
$user = getenv("MYSQLUSER") ?: "root";
$pass = getenv("MYSQLPASSWORD") ?: "";
$db = getenv("MYSQLDATABASE") ?: "civicfix";
$port = getenv("MYSQLPORT") ?: 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>