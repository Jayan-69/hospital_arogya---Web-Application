<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/db_connect.php'; // Include your database connection script

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['status' => 'error'];

    switch ($_POST['action']) {
        case 'add':
            $FirstName = $_POST['FirstName'] ?? null;
            $LastName = $_POST['LastName'] ?? null;
            $DateOfBirth = $_POST['DateOfBirth'] ?? null;
            $Gender = $_POST['Gender'] ?? null;
            $Address = $_POST['Address'] ?? null;
            $PhoneNumber = $_POST['PhoneNumber'] ?? null;
            $Email = $_POST['Email'] ?? null;
            $Department = $_POST['Department'] ?? null;
            $Designation = $_POST['Designation'] ?? null;
            $JoiningDate = $_POST['JoiningDate'] ?? null;

            if ($FirstName && $LastName && $DateOfBirth && $Gender && $Address && $PhoneNumber && $Email && $Department && $Designation && $JoiningDate) {
                $stmt = $pdo->prepare("INSERT INTO staff (FirstName, LastName, DateOfBirth, Gender, Address, PhoneNumber, Email, Department, Designation, JoiningDate) VALUES (:FirstName, :LastName, :DateOfBirth, :Gender, :Address, :PhoneNumber, :Email, :Department, :Designation, :JoiningDate)");
                $stmt->execute([
                    'FirstName' => $FirstName,
                    'LastName' => $LastName,
                    'DateOfBirth' => $DateOfBirth,
                    'Gender' => $Gender,
                    'Address' => $Address,
                    'PhoneNumber' => $PhoneNumber,
                    'Email' => $Email,
                    'Department' => $Department,
                    'Designation' => $Designation,
                    'JoiningDate' => $JoiningDate,
                ]);
                $response = ['status' => 'success', 'id' => $pdo->lastInsertId()];
            } else {
                $response['message'] = 'All fields are required.';
            }
            break;

        case 'update':
            $StaffID = $_POST['StaffID'] ?? null;
            $field = $_POST['field'] ?? null;
            $value = $_POST['value'] ?? null;

            if ($StaffID && $field && $value) {
                $stmt = $pdo->prepare("UPDATE staff SET $field = :value WHERE StaffID = :StaffID");
                $stmt->execute(['value' => $value, 'StaffID' => $StaffID]);
                $response = ['status' => 'success'];
            } else {
                $response['message'] = 'Invalid input data.';
            }
            break;

        case 'delete':
            $StaffID = $_POST['StaffID'] ?? null;

            if ($StaffID) {
                $stmt = $pdo->prepare("DELETE FROM staff WHERE StaffID = :StaffID");
                $stmt->execute(['StaffID' => $StaffID]);
                $response = ['status' => 'success'];
            } else {
                $response['message'] = 'Invalid ID.';
            }
            break;
    }

    echo json_encode($response);
    exit();
}
?>

<style>
    body {
        position: relative;
    }

    .bg-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 0.5; /* Reduced opacity for the background image */
    }

    .content-container {
        position: relative;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px; /* Push down the content */
    }
</style>

<div class="content-container">
    <div class="container mt-5">
        <h2 class="mb-4">Staff Members</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>StaffID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Joining Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    <?php
                    // Prepare and execute query
                    $sql = "SELECT * FROM staff";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='{$row['StaffID']}'>
                                <td>{$row['StaffID']}</td>
                                <td contenteditable='true' class='editable' data-field='FirstName'>{$row['FirstName']}</td>
                                <td contenteditable='true' class='editable' data-field='LastName'>{$row['LastName']}</td>
                                <td contenteditable='true' class='editable' data-field='DateOfBirth'>{$row['DateOfBirth']}</td>
                                <td contenteditable='true' class='editable' data-field='Gender'>{$row['Gender']}</td>
                                <td contenteditable='true' class='editable' data-field='Address'>{$row['Address']}</td>
                                <td contenteditable='true' class='editable' data-field='PhoneNumber'>{$row['PhoneNumber']}</td>
                                <td contenteditable='true' class='editable' data-field='Email'>{$row['Email']}</td>
                                <td contenteditable='true' class='editable' data-field='Department'>{$row['Department']}</td>
                                <td contenteditable='true' class='editable' data-field='Designation'>{$row['Designation']}</td>
                                <td contenteditable='true' class='editable' data-field='JoiningDate'>{$row['JoiningDate']}</td>
                                <td>
                                    <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12' class='text-center'>No staff members found</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>New</td>
                        <td contenteditable='true' class='editable' data-field='FirstName'></td>
                        <td contenteditable='true' class='editable' data-field='LastName'></td>
                        <td contenteditable='true' class='editable' data-field='DateOfBirth'></td>
                        <td contenteditable='true' class='editable' data-field='Gender'></td>
                        <td contenteditable='true' class='editable' data-field='Address'></td>
                        <td contenteditable='true' class='editable' data-field='PhoneNumber'></td>
                        <td contenteditable='true' class='editable' data-field='Email'></td>
                        <td contenteditable='true' class='editable' data-field='Department'></td>
                        <td contenteditable='true' class='editable' data-field='Designation'></td>
                        <td contenteditable='true' class='editable' data-field='JoiningDate'></td>
                        <td>
                            <button class='btn btn-success btn-sm add-btn'>Add</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Background Image with Reduced Opacity -->
<div class="bg-image">
    <!-- Replace with your desired background image -->
    <img src="images/background.jpg" class="img-fluid" alt="Background Image">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle inline editing
    $('.editable').on('blur', function() {
        var $this = $(this);
        var value = $this.text();
        var id = $this.closest('tr').data('id');
        var field = $this.data('field');
        
        $.ajax({
            url: 'staff.php',
            type: 'POST',
            data: { action: 'update', StaffID: id, field: field, value: value },
            success: function(response) {
                console.log(response);
            }
        });
    });

    // Handle delete
    $('.delete-btn').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('id');

        $.ajax({
            url: 'staff.php',
            type: 'POST',
            data: { action: 'delete', StaffID: id },
            success: function(response) {
                $row.remove();
            }
        });
    });

    // Handle add
    $('.add-btn').on('click', function() {
        var $row = $(this).closest('tr');
        var data = { action: 'add' };
        $row.find('.editable').each(function() {
            var field = $(this).data('field');
            data[field] = $(this).text();
        });

        $.ajax({
            url: 'staff.php',
            type: 'POST',
            data: data,
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
