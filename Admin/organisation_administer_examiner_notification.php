<?php
// session_start();
include('Admin_panel.php'); // Include your database connection file

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in admin's ID
$admin_id = $_SESSION['admin_id'];

// Fetch data from administer_table
$query = "SELECT administer_id, administer_name, exam_code, administer_email_address, administer_type FROM administer_table WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin_data = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-top: 20px; */
        }
        table, th, td {
            /* border: 1px solid black; */
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

<main id="main" class="main">
    <div class="pagetitle">
    <h1>Exam Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item"><a href="">Organisation</a></li>
                <li class="breadcrumb-item active">Notification Tables</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 sidebar-nav">
                    <button class="btn">
                    <a class="nav-link collapsed" href="organisation_administer_admin_panel.php">
                        <img src="image\back_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                        <span>  Back</span>
                    </a> 
                    </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body" style="margin: 10px 0;">
                    <h3 class="panel-title">Administer/Examiner List</h3>
                </div>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Administer ID</th>
                            <th>Administer Name</th>
                            <th>Exam Code</th>
                            <th>Email Address</th>
                            <th>Administer Type</th>
                            <th>Notification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admin_data as $admin) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($admin['administer_id']); ?></td>
                                <td><?php echo htmlspecialchars($admin['administer_name']); ?></td>
                                <td><?php echo htmlspecialchars($admin['exam_code']); ?></td>
                                <td><?php echo htmlspecialchars($admin['administer_email_address']); ?></td>
                                <td><?php echo htmlspecialchars($admin['administer_type']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm send-btn" data-id="<?php echo htmlspecialchars($admin['administer_id']); ?>" data-name="<?php echo htmlspecialchars($admin['administer_name']); ?>">Send</button>
                                    <button type="button" class="btn btn-info btn-sm view-btn" data-id="<?php echo htmlspecialchars($admin['administer_id']); ?>">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Send Notification Modal -->
        <div class="modal" id="sendModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Send Notification</h4>
                        <button type="button" class="close" id="closeButton" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="sendNotificationForm">
                            <div class="form-group">
                                <label for="notification_msg">Message:</label>
                                <textarea class="form-control" id="notification_msg" name="notification_msg" required></textarea>
                            </div>
                            <input type="hidden" id="administer_id" name="administer_id">
                            <input type="hidden" id="administer_name" name="administer_name">
                            <button type="submit" class="btn btn-success">Send</button>
                            <button type="button" class="btn btn-default" id="closeModalButton">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Notifications Modal -->
        <div class="modal" id="viewModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Notifications</h4>
                        <button type="button" class="close" id="closeButton" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="notificationContent"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="delete_notification_button">Delete</button>
                        <button type="button" class="btn btn-primary btn-sm" id="closeModalButton" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    <section>
</main>
    <!-- Include your footer here -->
    <?php include('footer.php'); ?>
    <!------------------------------------------------------------>

    <script>
        $(document).ready(function() {
            // Show the modal when the Send button is clicked
            $('.send-btn').click(function() {
                var administer_id = $(this).data('id');
                var administer_name = $(this).data('name');
                $('#administer_id').val(administer_id);
                $('#administer_name').val(administer_name);
                $('#sendModal').modal('show');
            });

            // Handle the form submission for sending notifications
            $('#sendNotificationForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                
                $.ajax({
                    url: 'organisation_send_view_delete_notifications.php', // PHP script to handle form submission
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response);
                        $('#sendModal').modal('hide');
                    },
                    error: function() {
                        alert('An error occurred while sending the notification.');
                    }
                });
            });

            // Show the modal when the View button is clicked
            $('.view-btn').click(function() {
                var administer_id = $(this).data('id');
                $.ajax({
                    url: 'organisation_send_view_delete_notifications.php',
                    type: 'POST',
                    data: { view_notifications: true, administer_id: administer_id },
                    success: function(response) {
                        $('#notificationContent').html(response);
                        $('#viewModal').modal('show');
                    },
                    error: function() {
                        alert('An error occurred while fetching notifications.');
                    }
                });
            });

            // Delete notification
            $('#delete_notification_button').click(function() {
                if (confirm("Are you sure you want to delete this notification?")) {
                    var administer_id = $('#administer_id').val();
                    $.ajax({
                        url: 'organisation_send_view_delete_notifications.php',
                        type: 'POST',
                        data: { delete_notification: true, administer_id: administer_id },
                        success: function(response) {
                            alert(response);
                            $('#viewModal').modal('hide');
                        },
                        error: function() {
                            alert('An error occurred while deleting the notification.');
                        }
                    });
                }
            });

            $('#closeButton, #closeModalButton').click(function() {
                $('#sendModal').modal('hide');
            });
            $('#closeButton, #closeModalButton').click(function() {
                $('#viewModal').modal('hide');
            });
        });
    </script>
