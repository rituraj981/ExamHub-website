<?php

include('../mainfile.php');
include('../Admin/Examination.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'update_status') {
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];

        // Create an instance of your Exam class or use existing instance
        $exam = new Examination();

        $query = "UPDATE `user_table` SET `user_email_verified` = ? WHERE `user_id` = ?";
        $stmt = $exam->connect->prepare($query);
        $stmt->execute([$status, $user_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['user_email_verified' => true, 'message' => 'Student are Present updated successfully']);
        } else {
            echo json_encode(['user_email_verified' => false, 'message' => 'Failed to update status']);
        }
    }
}
?>