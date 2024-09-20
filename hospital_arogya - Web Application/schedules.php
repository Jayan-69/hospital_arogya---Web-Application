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
            $PatientID = $_POST['PatientID'] ?? null;
            $DoctorID = $_POST['DoctorID'] ?? null;
            $RoomID = $_POST['RoomID'] ?? null;
            $AppointmentDate = $_POST['AppointmentDate'] ?? null;
            $StartTime = $_POST['StartTime'] ?? null;
            $EndTime = $_POST['EndTime'] ?? null;
            $Status = $_POST['Status'] ?? null;
            $Remarks = $_POST['Remarks'] ?? null;

            if ($PatientID && $DoctorID && $RoomID && $AppointmentDate && $StartTime && $EndTime && $Status) {
                $stmt = $pdo->prepare("INSERT INTO scheduling (PatientID, DoctorID, RoomID, AppointmentDate, StartTime, EndTime, Status, Remarks) VALUES (:PatientID, :DoctorID, :RoomID, :AppointmentDate, :StartTime, :EndTime, :Status, :Remarks)");
                $stmt->execute([
                    'PatientID' => $PatientID,
                    'DoctorID' => $DoctorID,
                    'RoomID' => $RoomID,
                    'AppointmentDate' => $AppointmentDate,
                    'StartTime' => $StartTime,
                    'EndTime' => $EndTime,
                    'Status' => $Status,
                    'Remarks' => $Remarks
                ]);
                $response = ['status' => 'success', 'id' => $pdo->lastInsertId()];
            } else {
                $response['message'] = 'All fields are required.';
            }
            break;

        case 'update':
            $ScheduleID = $_POST['ScheduleID'] ?? null;
            $field = $_POST['field'] ?? null;
            $value = $_POST['value'] ?? null;

            if ($ScheduleID && $field && $value) {
                $stmt = $pdo->prepare("UPDATE scheduling SET $field = :value WHERE ScheduleID = :ScheduleID");
                $stmt->execute(['value' => $value, 'ScheduleID' => $ScheduleID]);
                $response = ['status' => 'success'];
            } else {
                $response['message'] = 'Invalid input data.';
            }
            break;

        case 'delete':
            $ScheduleID = $_POST['ScheduleID'] ?? null;

            if ($ScheduleID) {
                $stmt = $pdo->prepare("DELETE FROM scheduling WHERE ScheduleID = :ScheduleID");
                $stmt->execute(['ScheduleID' => $ScheduleID]);
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
        <h2 class="mb-4">Schedules</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ScheduleID</th>
                        <th>Patient ID</th>
                        <th>Doctor ID</th>
                        <th>Room ID</th>
                        <th>Appointment Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="schedulingTableBody">
                    <?php
                    // Prepare and execute query
                    $sql = "SELECT * FROM scheduling";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='{$row['ScheduleID']}'>
                                <td>{$row['ScheduleID']}</td>
                                <td contenteditable='true' class='editable' data-field='PatientID'>{$row['PatientID']}</td>
                                <td contenteditable='true' class='editable' data-field='DoctorID'>{$row['DoctorID']}</td>
                                <td contenteditable='true' class='editable' data-field='RoomID'>{$row['RoomID']}</td>
                                <td contenteditable='true' class='editable' data-field='AppointmentDate'>{$row['AppointmentDate']}</td>
                                <td contenteditable='true' class='editable' data-field='StartTime'>{$row['StartTime']}</td>
                                <td contenteditable='true' class='editable' data-field='EndTime'>{$row['EndTime']}</td>
                                <td contenteditable='true' class='editable' data-field='Status'>{$row['Status']}</td>
                                <td contenteditable='true' class='editable' data-field='Remarks'>{$row['Remarks']}</td>
                                <td>
                                    <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No schedules found</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>New</td>
                        <td contenteditable='true' class='editable' data-field='PatientID'></td>
                        <td contenteditable='true' class='editable' data-field='DoctorID'></td>
                        <td contenteditable='true' class='editable' data-field='RoomID'></td>
                        <td contenteditable='true' class='editable' data-field='AppointmentDate'></td>
                        <td contenteditable='true' class='editable' data-field='StartTime'></td>
                        <td contenteditable='true' class='editable' data-field='EndTime'></td>
                        <td contenteditable='true' class='editable' data-field='Status'></td>
                        <td contenteditable='true' class='editable' data-field='Remarks'></td>
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
            url: 'schedules.php',
            type: 'POST',
            data: { action: 'update', ScheduleID: id, field: field, value: value },
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
            url: 'schedules.php',
            type: 'POST',
            data: { action: 'delete', ScheduleID: id },
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
            url: 'schedules.php',
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
