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
            $InvoiceDate = $_POST['InvoiceDate'] ?? null;
            $TotalAmount = $_POST['TotalAmount'] ?? null;
            $Paid = $_POST['Paid'] ?? null;

            if ($PatientID && $InvoiceDate && $TotalAmount && $Paid) {
                $stmt = $pdo->prepare("INSERT INTO invoices (PatientID, InvoiceDate, TotalAmount, Paid) VALUES (:PatientID, :InvoiceDate, :TotalAmount, :Paid)");
                $stmt->execute([
                    'PatientID' => $PatientID,
                    'InvoiceDate' => $InvoiceDate,
                    'TotalAmount' => $TotalAmount,
                    'Paid' => $Paid
                ]);
                $response = ['status' => 'success', 'id' => $pdo->lastInsertId()];
            } else {
                $response['message'] = 'All fields are required.';
            }
            break;

        case 'update':
            $InvoiceID = $_POST['InvoiceID'] ?? null;
            $field = $_POST['field'] ?? null;
            $value = $_POST['value'] ?? null;

            if ($InvoiceID && $field && $value) {
                $stmt = $pdo->prepare("UPDATE invoices SET $field = :value WHERE InvoiceID = :InvoiceID");
                $stmt->execute(['value' => $value, 'InvoiceID' => $InvoiceID]);
                $response = ['status' => 'success'];
            } else {
                $response['message'] = 'Invalid input data.';
            }
            break;

        case 'delete':
            $InvoiceID = $_POST['InvoiceID'] ?? null;

            if ($InvoiceID) {
                $stmt = $pdo->prepare("DELETE FROM invoices WHERE InvoiceID = :InvoiceID");
                $stmt->execute(['InvoiceID' => $InvoiceID]);
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
        <h2 class="mb-4">Invoices</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>InvoiceID</th>
                        <th>Patient ID</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>
                        <th>Paid</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="invoicesTableBody">
                    <?php
                    // Prepare and execute query
                    $sql = "SELECT * FROM invoices";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='{$row['InvoiceID']}'>
                                <td>{$row['InvoiceID']}</td>
                                <td contenteditable='true' class='editable' data-field='PatientID'>{$row['PatientID']}</td>
                                <td contenteditable='true' class='editable' data-field='InvoiceDate'>{$row['InvoiceDate']}</td>
                                <td contenteditable='true' class='editable' data-field='TotalAmount'>{$row['TotalAmount']}</td>
                                <td contenteditable='true' class='editable' data-field='Paid'>{$row['Paid']}</td>
                                <td>
                                    <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No invoices found</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>New</td>
                        <td contenteditable='true' class='editable' data-field='PatientID'></td>
                        <td contenteditable='true' class='editable' data-field='InvoiceDate'></td>
                        <td contenteditable='true' class='editable' data-field='TotalAmount'></td>
                        <td contenteditable='true' class='editable' data-field='Paid'></td>
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
            url: 'invoices.php',
            type: 'POST',
            data: { action: 'update', InvoiceID: id, field: field, value: value },
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
            url: 'invoices.php',
            type: 'POST',
            data: { action: 'delete', InvoiceID: id },
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
            url: 'invoices.php',
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
