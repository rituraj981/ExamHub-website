<?php
include('../mainfile.php');

if (isset($_POST['user_id']) && isset($_POST['exam_code'])) {
    $user_id = $_POST['user_id'];
    $exam_code = $_POST['exam_code'];

    // Log incoming data
    error_log("User ID: " . $user_id);
    error_log("Exam Code: " . $exam_code);

    // Fetch user result data
    $stmt = $conn->prepare("SELECT crd.`user_name`, crd.`user_id`, crd.`exam_code`, crd.`enrollment_number`, crd.`total_question`, crd.`total_marks`, crd.`percentage`, oet.`online_exam_id`, oet.`online_exam_title` , oet.`online_exam_duration`
    FROM `calculation_result_data` crd
    JOIN `online_exam_table` oet ON crd.`exam_code` = oet.`exam_code`
    WHERE crd.`user_id` = ? AND crd.`exam_code` = ?");
    if ($stmt === false) {
        error_log('Prepare failed: ' . htmlspecialchars($conn->error));
        echo json_encode([]);
        exit;
    }
    $stmt->bind_param("is", $user_id, $exam_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        error_log('Execute failed: ' . htmlspecialchars($stmt->error));
        echo json_encode([]);
        exit;
    }
    $user_data = $result->fetch_assoc();
    $stmt->close();

    if ($user_data) {
        // Fetch section data
        $stmt = $conn->prepare("SELECT `section_name`, `total_questions`, `total_right_answer`, `total_wrong_answer`, `minimum_mark`, `negative_mark`, `total_mark`, `user_mark` FROM `section_calculation_result_data` WHERE `exam_code` = ? AND `user_id` = ?");
        if ($stmt === false) {
            error_log('Prepare failed: ' . htmlspecialchars($conn->error));
            echo json_encode([]);
            exit;
        }
        $stmt->bind_param("si", $exam_code, $user_id);
        $stmt->execute();
        $sections_result = $stmt->get_result();
        if ($sections_result === false) {
            error_log('Execute failed: ' . htmlspecialchars($stmt->error));
            echo json_encode([]);
            exit;
        }
        $sections = [];
        while ($row = $sections_result->fetch_assoc()) {
            $sections[] = $row;
        }
        $stmt->close();

        $user_data['sections'] = $sections;

        echo json_encode($user_data);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
