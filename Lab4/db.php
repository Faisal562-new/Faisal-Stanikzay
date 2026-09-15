<?php
/* ==========================================================
   TASK 1: DATABASE CONNECTION
   File: db.php
   ========================================================== */

// MySQL connection information
$host = "localhost";
$username = "root";
$password = "";
$database = "admission_db";

// Connect to MySQL server
$conn = new mysqli($host, $username, $password);

// Check MySQL server connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Create the database if it does not exist
$createDatabase = "CREATE DATABASE IF NOT EXISTS admission_db";

if (!$conn->query($createDatabase)) {
    die("Could not create database: " . $conn->error);
}

// Select the admission_db database
$conn->select_db($database);

// Create the applications table if it does not exist
$createTable = "
    CREATE TABLE IF NOT EXISTS applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        father_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        program VARCHAR(100) NOT NULL
    )
";

if (!$conn->query($createTable)) {
    die("Could not create applications table: " . $conn->error);
}
?>
