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
            $RoomNumber = isset($_POST['RoomNumber']) ? $_POST['RoomNumber'] : '';
            $RoomType = isset($_POST['RoomType']) ? $_POST['RoomType'] : '';
            $BedCount = isset($_POST['BedCount']) ? $_POST['BedCount'] : '';
            $Availability = isset($_POST['Availability']) ? $_POST['Availability'] : '';

            $stmt = $pdo->prepare("INSERT INTO rooms (RoomNumber, RoomType, BedCount, Availability) VALUES (:RoomNumber, :RoomType, :BedCount, :Availability)");
            $stmt->execute([
                'RoomNumber' => $RoomNumber,
                'RoomType' => $RoomType,
                'BedCount' => $BedCount,
                'Availability' => $Availability,
            ]);
            $response = ['status' => 'success', 'id' => $pdo->lastInsertId()];
            break;

        case 'update':
            $RoomID = isset($_POST['RoomID']) ? $_POST['RoomID'] : '';
            $field = isset($_POST['field']) ? $_POST['field'] : '';
            $value = isset($_POST['value']) ? $_POST['value'] : '';

            if ($RoomID && $field && $value) {
                $stmt = $pdo->prepare("UPDATE rooms SET $field = :value WHERE RoomID = :RoomID");
                $stmt->execute(['value' => $value, 'RoomID' => $RoomID]);
                $response = ['status' => 'success'];
            }
            break;

        case 'delete':
            $RoomID = isset($_POST['RoomID']) ? $_POST['RoomID'] : '';

            if ($RoomID) {
                $stmt = $pdo->prepare("DELETE FROM rooms WHERE RoomID = :RoomID");
                $stmt->execute(['RoomID' => $RoomID]);
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
        <h2 class="mb-4">Rooms</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>RoomID</th>
                        <th>RoomNumber</th>
                        <th>RoomType</th>
                        <th>BedCount</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="roomTableBody">
                    <?php
                    // Prepare and execute query
                    $sql = "SELECT * FROM rooms";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='{$row['RoomID']}'>
                                <td>{$row['RoomID']}</td>
                                <td contenteditable='true' class='editable' data-field='RoomNumber'>{$row['RoomNumber']}</td>
                                <td contenteditable='true' class='editable' data-field='RoomType'>{$row['RoomType']}</td>
                                <td contenteditable='true' class='editable' data-field='BedCount'>{$row['BedCount']}</td>
                                <td contenteditable='true' class='editable' data-field='Availability'>{$row['Availability']}</td>
                                <td>
                                    <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No rooms found</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>New</td>
                        <td contenteditable='true' class='editable' data-field='RoomNumber'></td>
                        <td contenteditable='true' class='editable' data-field='RoomType'></td>
                        <td contenteditable='true' class='editable' data-field='BedCount'></td>
                        <td contenteditable='true' class='editable' data-field='Availability'></td>
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
            url: 'rooms.php',
            type: 'POST',
            data: { action: 'update', RoomID: id, field: field, value: value },
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
            url: 'rooms.php',
            type: 'POST',
            data: { action: 'delete', RoomID: id },
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
            url: 'rooms.php',
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
