<?php
include '../mainfile.php';
include('../Admin/Examination.php');

$exam = new Examination;
$admin_id = $_SESSION['admin_id'];

if (isset($_GET['code'])) {
    $exam_code = $_GET['code'];
    $total_user_attempted = 0;

    // Query to check if result_published is true (1)
    $query = "
    SELECT result_published FROM online_exam_table 
    WHERE exam_code = ? AND admin_id = ?
    ";
    $statement = $conn->prepare($query);
    $statement->bind_param('si', $exam_code, $admin_id);
    $statement->execute();
    $result = $statement->get_result()->fetch_assoc();

    if ($result) {
        if ($result['result_published'] == 1) {
            $_SESSION['message'] = 'Result already published';
            header("Location: Exam_result_panel.php");
            exit();
        } else {
            // Update the result_published value to 1
            $update_query = "
            UPDATE online_exam_table 
            SET result_published = 1 
            WHERE exam_code = ? AND admin_id = ?
            ";
            $update_statement = $conn->prepare($update_query);
            $update_statement->bind_param('si', $exam_code, $admin_id);
            $update_statement->execute();

            $_SESSION['message'] = 'Result processed successfully';
        }
    } else {
        $_SESSION['message'] = 'No matching record found';
    }

    // Fetch user answers and corresponding question details
    $sqlUserAnswers = "
    SELECT ua.user_id, ua.question_id, ua.selected_option, q.marks_per_right_answer, q.marks_per_wrong_answer, q.exam_subject_question_answer, q.section_name
    FROM user_answers ua
    JOIN all_subject_question_paper q ON ua.question_id = q.question_id
    WHERE q.exam_code = ?
    ";
    
    $statementUserAnswers = $conn->prepare($sqlUserAnswers);
    $statementUserAnswers->bind_param('s', $exam_code);
    $statementUserAnswers->execute();
    $resultUserAnswers = $statementUserAnswers->get_result();
    
    if ($resultUserAnswers->num_rows > 0) {
        // Initialize arrays to store user-specific and section-specific calculations
        $user_attempted_questions = [];
        $user_right_answers = [];
        $user_wrong_answers = [];
        $marks_per_wrong_answer = 0;
        $marks_per_right_answer = 0;

        // Arrays to store section-wise data
        $section_data = [];

        // Get total questions for the exam
        $sqlExamDetails = "SELECT total_question FROM online_exam_table WHERE exam_code = ?";
        $statementExamDetails = $conn->prepare($sqlExamDetails);
        $statementExamDetails->bind_param('s', $exam_code);
        $statementExamDetails->execute();
        $resultExamDetails = $statementExamDetails->get_result();
        $exam_total_questions = 0;

        if ($resultExamDetails->num_rows > 0) {
            $examDetails = $resultExamDetails->fetch_assoc();
            $exam_total_questions = $examDetails['total_question'];
        }

        while ($row = $resultUserAnswers->fetch_assoc()) {
            $user_id = $row['user_id'];
            $marks_per_right_answer = $row['marks_per_right_answer'];
            $marks_per_wrong_answer = $row['marks_per_wrong_answer'];
            $exam_subject_question_answer = $row['exam_subject_question_answer'];
            $selected_option = $row['selected_option'];
            $section_name = $row['section_name'];
            
            // Initialize user-specific data if not already done
            if (!isset($user_attempted_questions[$user_id])) {
                $user_attempted_questions[$user_id] = 0;
                $user_right_answers[$user_id] = 0;
                $user_wrong_answers[$user_id] = 0;
                $total_user_attempted++;
            }
            
            // Initialize section-specific data if not already done
            if (!isset($section_data[$user_id])) {
                $section_data[$user_id] = [];
            }
            if (!isset($section_data[$user_id][$section_name])) {
                $section_data[$user_id][$section_name] = [
                    'total_questions' => 0,
                    'attempted_questions' => 0,
                    'not_attempted_questions' => 0,
                    'total_right_answers' => 0,
                    'total_wrong_answers' => 0,
                    'marks_per_right_answer' => $marks_per_right_answer,
                    'marks_per_wrong_answer' => $marks_per_wrong_answer
                ];
            }

            // Update global user-specific data
            if ($selected_option !== null) {
                $user_attempted_questions[$user_id]++;
                $section_data[$user_id][$section_name]['attempted_questions']++;
            } else {
                $section_data[$user_id][$section_name]['total_questions']++;
            }

            if ($selected_option == $exam_subject_question_answer) {
                $user_right_answers[$user_id]++;
                $section_data[$user_id][$section_name]['total_right_answers']++;
            } elseif ($selected_option !== null) {
                $user_wrong_answers[$user_id]++;
                $section_data[$user_id][$section_name]['total_wrong_answers']++;
            }

            $section_data[$user_id][$section_name]['total_questions']++;
        }
        
        foreach ($user_attempted_questions as $user_id => $attempted_questions) {
            $right_answers = $user_right_answers[$user_id];
            $wrong_answers = $user_wrong_answers[$user_id];
            $not_attempted_questions = $exam_total_questions - $attempted_questions;

            // Calculate minimum marks
            $maximum_marks = $right_answers * $marks_per_right_answer;

            // Calculate negative marks
            $negative_marks = $wrong_answers * $marks_per_wrong_answer;

            // Calculate total marks
            $total_marks = $exam_total_questions * $marks_per_right_answer;

            // Calculate user marks
            $user_marks = $maximum_marks - $negative_marks;

            // Calculate percentage
            $percentage = ($user_marks / $total_marks) * 100;

            // Fetch user details
            $sqlUserDetails = "SELECT user_name, enrollment_number FROM user_table WHERE user_id = ?";
            $statementUserDetails = $conn->prepare($sqlUserDetails);
            $statementUserDetails->bind_param('i', $user_id);
            $statementUserDetails->execute();
            $resultUserDetails = $statementUserDetails->get_result();

            if ($resultUserDetails->num_rows > 0) {
                $userDetails = $resultUserDetails->fetch_assoc();
                $user_name = $userDetails['user_name'];
                $enrollment_number = $userDetails['enrollment_number'];

                // Fetch exam details
                $sqlExamDetails = "SELECT online_exam_title FROM online_exam_table WHERE exam_code = ?";
                $statementExamDetails = $conn->prepare($sqlExamDetails);
                $statementExamDetails->bind_param('s', $exam_code);
                $statementExamDetails->execute();
                $resultExamDetails = $statementExamDetails->get_result();

                if ($resultExamDetails->num_rows > 0) {
                    $examDetails = $resultExamDetails->fetch_assoc();
                    $exam_name = $examDetails['online_exam_title'];

                    // Insert calculation result data
                    $sqlInsert = "INSERT INTO calculation_result_data 
                                    (user_id, admin_id, exam_code, user_name, enrollment_number, exam_name, total_question, attempted_questions, not_attempted_questions, total_right_answers, total_wrong_answers, maximum_marks, negative_marks, total_marks, user_marks, percentage)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $statementInsert = $conn->prepare($sqlInsert);
                    $statementInsert->bind_param('iisssiiiiiiiiiii', $user_id, $admin_id, $exam_code, $user_name, $enrollment_number, $exam_name, $exam_total_questions, $attempted_questions, $not_attempted_questions, $right_answers, $wrong_answers, $maximum_marks, $negative_marks, $total_marks, $user_marks, $percentage);
                    $statementInsert->execute();

                    if ($statementInsert->error) {
                        echo "Error: " . $statementInsert->error;
                    }

                    // Section-wise results insertion
                    foreach ($section_data[$user_id] as $section_name => $section) {
                        $section_total_questions = $section['total_questions'];
                        $section_attempted_questions = $section['attempted_questions'];
                        $section_not_attempted_questions = $section_total_questions - $section_attempted_questions;
                        $section_total_right_answers = $section['total_right_answers'];
                        $section_total_wrong_answers = $section['total_wrong_answers'];
                        $section_maximum_marks = $section_total_right_answers * $section['marks_per_right_answer'];
                        $section_negative_marks = $section_total_wrong_answers * $section['marks_per_wrong_answer'];
                        $section_total_marks = $section_total_questions * $section['marks_per_right_answer'];
                        $section_user_marks = $section_maximum_marks - $section_negative_marks;
                        $section_percentage = ($section_user_marks / $section_total_marks) * 100;

                        $sqlInsertSection = "INSERT INTO section_calculation_result_data 
                            (user_id, admin_id, exam_code, section_name, total_questions, attempted_questions, not_attempted_questions, total_right_answer, total_wrong_answer, minimum_mark, negative_mark, total_mark, user_mark, percentagee)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $statementInsertSection = $conn->prepare($sqlInsertSection);
                        $statementInsertSection->bind_param('iisssiiiiiiiii', $user_id, $admin_id, $exam_code, $section_name, $section_total_questions, $section_attempted_questions, $section_not_attempted_questions, $section_total_right_answers, $section_total_wrong_answers, $section_maximum_marks, $section_negative_marks, $section_total_marks, $section_user_marks, $section_percentage);
                        $statementInsertSection->execute();
                        
                        if ($statementInsertSection->error) {
                            echo "Error: " . $statementInsertSection->error;
                        }
                    }
                } else {
                    echo "No exam details found for the specified exam_code.";
                }
            } else {
                echo "No user details found for the specified user_id.";
            }
        }
    } else {
        echo "No user answers found for the specified exam_code.";
    }

    $conn->close();
    // Redirect to Exam_result_panel.php after processing
    header("Location: Exam_result_panel.php");
    exit();
} else {
    echo "No exam code specified.";
}
?>
