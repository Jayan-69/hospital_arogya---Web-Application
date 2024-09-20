<?php
// Database configuration
$host = "localhost"; // Change this if your database host is different
$username = "root"; // Database username
$password = ""; // Database password, leave empty if none
$dbname = "arogya_hospitals"; // Database name

try {
    // Using PDO for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection error: ' . $e->getMessage());
}

// Optional: Using mysqli for legacy compatibility if needed
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection (if using mysqli, although PDO connection is preferred)
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

