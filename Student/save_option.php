<?php
include '../mainfile.php';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$question_id = $_POST['question_id'];
$user_id = $_POST['user_id'];
$selected_option = $_POST['selected_option'];

// Save or update answer using REPLACE
$stmt = $conn->prepare("REPLACE INTO `user_answers` (`question_id`, `user_id`, `selected_option`) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $question_id, $user_id, $selected_option);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = $stmt->error;
}

echo json_encode($response);
$stmt->close();
$conn->close();
?>
