<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
include 'includes/db_connect.php'; // Assuming this includes your database connection setup

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = ['status' => 'error'];

    switch ($_POST['action']) {
        case 'add':
            $FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
            $LastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
            $DateOfBirth = isset($_POST['DateOfBirth']) ? $_POST['DateOfBirth'] : null;
            $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : null;
            $Address = isset($_POST['Address']) ? $_POST['Address'] : '';
            $PhoneNumber = isset($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : '';
            $Email = isset($_POST['Email']) ? $_POST['Email'] : '';
            $MedicalHistory = isset($_POST['MedicalHistory']) ? $_POST['MedicalHistory'] : '';

            $stmt = $pdo->prepare("INSERT INTO patients (FirstName, LastName, DateOfBirth, Gender, Address, PhoneNumber, Email, MedicalHistory) VALUES (:FirstName, :LastName, :DateOfBirth, :Gender, :Address, :PhoneNumber, :Email, :MedicalHistory)");
            $stmt->execute([
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'DateOfBirth' => $DateOfBirth,
                'Gender' => $Gender,
                'Address' => $Address,
                'PhoneNumber' => $PhoneNumber,
                'Email' => $Email,
                'MedicalHistory' => $MedicalHistory,
            ]);
            $response = ['status' => 'success', 'id' => $pdo->lastInsertId()];
            break;

        case 'update':
            $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : '';
            $field = isset($_POST['field']) ? $_POST['field'] : '';
            $value = isset($_POST['value']) ? $_POST['value'] : '';

            if ($PatientID && $field && $value) {
                $stmt = $pdo->prepare("UPDATE patients SET $field = :value WHERE PatientID = :PatientID");
                $stmt->execute(['value' => $value, 'PatientID' => $PatientID]);
                $response = ['status' => 'success'];
            }
            break;

        case 'delete':
            $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : '';

            if ($PatientID) {
                $stmt = $pdo->prepare("DELETE FROM patients WHERE PatientID = :PatientID");
                $stmt->execute(['PatientID' => $PatientID]);
                $response = ['status' => 'success'];
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
        <h2 class="mb-4">Patients</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>PatientID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>DateOfBirth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>PhoneNumber</th>
                        <th>Email</th>
                        <th>MedicalHistory</th>
                        <th>RegistrationDate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody">
                    <?php
                    // Prepare and execute query
                    $sql = "SELECT * FROM patients";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='{$row['PatientID']}'>
                                <td>{$row['PatientID']}</td>
                                <td contenteditable='true' class='editable' data-field='FirstName'>{$row['FirstName']}</td>
                                <td contenteditable='true' class='editable' data-field='LastName'>{$row['LastName']}</td>
                                <td contenteditable='true' class='editable' data-field='DateOfBirth'>{$row['DateOfBirth']}</td>
                                <td contenteditable='true' class='editable' data-field='Gender'>{$row['Gender']}</td>
                                <td contenteditable='true' class='editable' data-field='Address'>{$row['Address']}</td>
                                <td contenteditable='true' class='editable' data-field='PhoneNumber'>{$row['PhoneNumber']}</td>
                                <td contenteditable='true' class='editable' data-field='Email'>{$row['Email']}</td>
                                <td contenteditable='true' class='editable' data-field='MedicalHistory'>{$row['MedicalHistory']}</td>
                                <td>{$row['RegistrationDate']}</td>
                                <td>
                                    <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>No patients found</td></tr>";
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
                        <td contenteditable='true' class='editable' data-field='MedicalHistory'></td>
                        <td></td>
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
            url: 'patients.php',
            type: 'POST',
            data: { action: 'update', id: id, field: field, value: value },
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
            url: 'patients.php',
            type: 'POST',
            data: { action: 'delete', id: id },
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
            url: 'patients.php',
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
