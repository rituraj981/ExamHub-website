<?php

include('Admin_panel.php'); // Include your database connection file

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$admin_id = $_SESSION['admin_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['view_notifications'])) {
        $administer_id = $_POST['administer_id'];

        $query = "SELECT notification_id, notification_msg, created_at FROM administer_notification_table WHERE administer_id = ? AND admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $administer_id, $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<p data-id='{$row['notification_id']}'><strong>{$row['created_at']}:</strong> {$row['notification_msg']}</p>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_notification'])) {
        $id = $_POST['id'];

        // Ensure the notification belongs to the admin
        $query = "DELETE FROM administer_notification_table WHERE notification_id = ? AND admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id, $admin_id);

        if ($stmt->execute()) {
            echo "Notification deleted successfully.";
        } else {
            echo "An error occurred.";
        }

        $stmt->close();
    } else {
        $administer_id = $_POST['administer_id'];
        $administer_name = $_POST['administer_name'];
        $notification_msg = $_POST['notification_msg'];

        $query = "INSERT INTO administer_notification_table (administer_id, administer_name, admin_id, notification_msg) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isis", $administer_id, $administer_name, $admin_id, $notification_msg);

        if ($stmt->execute()) {
            echo "Notification sent successfully.";
        } else {
            echo "An error occurred.";
        }

        $stmt->close();
    }
    $conn->close();
}
?>
