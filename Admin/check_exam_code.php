<?php
include '../mainfile.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['exam_code'])) {
    $exam_code = $conn->real_escape_string($_POST['exam_code']);
    $sql = "SELECT online_exam_id FROM online_exam_table WHERE exam_code = '$exam_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}

$conn->close();
?>
