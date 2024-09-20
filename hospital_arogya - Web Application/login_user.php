<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'includes/db_connect.php';

    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch user from database
    $sql = "SELECT * FROM logins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if ($result) {
        // Check number of rows returned
        if (mysqli_num_rows($result) == 1) {
            // If user exists, set session variables and redirect to index.php
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username']; // Set session username
            $_SESSION['user_id'] = $row['user_id'];   // Optionally set other user details if needed
            header("Location: index.php");
            exit();
        } else {
            // If no user found, set error message and redirect back to login.php
            $_SESSION['error_message'] = "Invalid username or password";
            header("Location: login.php");
            exit();
        }
    } else {
        // If query fails, log the error and redirect back to login.php with an error message
        $_SESSION['error_message'] = "Database query failed: " . mysqli_error($conn);
        header("Location: login.php");
        exit();
    }
} else {
    // If access directly without POST request, redirect to login.php
    header("Location: login.php");
    exit();
}
?>
