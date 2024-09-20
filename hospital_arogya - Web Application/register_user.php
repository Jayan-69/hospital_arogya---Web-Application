<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


// Redirect if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include header
include 'includes/header.php';

// Include database connection
include 'includes/db_connect.php'; // Adjust path as needed

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long.";
    }

    // If no errors, proceed with registration
    if (!isset($_SESSION['error_message'])) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql_insert_user = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt_insert_user = $pdo->prepare($sql_insert_user);
        if ($stmt_insert_user->execute([$username, $email, $hashed_password])) {
            // Registration successful, redirect to login page or provide feedback
            $_SESSION['message'] = "Registration successful. You can now login.";
            header("Location: login.php");
            exit();
        } else {
            // Handle database errors
            $_SESSION['error_message'] = "Registration failed. Please try again later.";
        }
    } else {
        $_SESSION['error_message'] = "Error occurred while registering. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Arogya Health Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden; /* Prevent scrolling */
            background-color: #f8f9fa; /* Light grey background color */
        }
        .register-container {
            background-color: #ffffff; /* White background */
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000; /* Ensure the navbar stays on top */
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            color: white;
            text-align: center;
            padding: 20px 0;
            z-index: 1000; /* Ensure the footer stays on top */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="register-container text-center">
    <h2>New Registration</h2>
    <br>
    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="number" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Include footer or any closing scripts
include 'includes/footer.php';
?>