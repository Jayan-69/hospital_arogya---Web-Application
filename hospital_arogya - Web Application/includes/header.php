<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arogya Health Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        /* Custom CSS for header styling */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff; /* White text */
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #fff; /* White text for links */
            font-weight: 500;
            padding: 8px 15px; /* Adjust padding for buttons */
            transition: background-color 0.3s ease; /* Smooth transition for background color */
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1); /* Light grey on hover */
            border-radius: 5px; /* Rounded corners on hover */
        }
        .navbar-dark .navbar-toggler-icon {
            border-color: #fff; /* White color for toggle icon */
        }
        .navbar-dark .navbar-toggler {
            border-color: #fff; /* White color for toggle button border */
        }
        .navbar-dark .navbar-collapse {
            background-color: #343a40; /* Dark background for navbar collapse */
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Arogya Health Care</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="patients.php">Patient Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">Room Availability</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff.php">Staff</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="schedules.php">Room Schedules</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="invoices.php">Patient Invoices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register_user.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="confirmLogout()">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Your content here -->

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
