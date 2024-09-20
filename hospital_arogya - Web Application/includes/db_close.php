<?php
// Check if PDO connection exists and close it
if (isset($pdo)) {
    $pdo = null; // Close PDO connection
}

// Check if mysqli connection exists and close it
if (isset($conn)) {
    mysqli_close($conn); // Close mysqli connection
}
?>
