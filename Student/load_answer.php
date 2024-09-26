<?php
// Include your database connection
include '../mainfile.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = $_POST['question_id'];
    $user_id = $_POST['user_id'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT selected_option FROM user_answers WHERE question_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $question_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($selected_option);
    $stmt->fetch();

    // Output the result
    if ($selected_option !== null) {
        echo json_encode(['status' => 'success', 'selected_option' => $selected_option]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No answer found']);
    }

    $stmt->close();
    $conn->close();
}
?>
