<?php
include '../mainfile.php';
include('Examination.php');

$exam = new Examination;

$admin_id = $_SESSION['admin_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {

    // Check for file size limit
    if ($_FILES["file"]["size"] > 10485760) { // 10 MB in bytes
        echo '<script type="text/javascript">
                alert("File size exceeds the maximum limit");
              </script>';
        exit();
    }

    // Get form data
    $exam_code = $_POST['exam_code'];
    $section_name = $_POST['section_name'];
    $total_question = $_POST['total_question'];
    $marks_per_right_answer = $_POST['marks_per_right_answer'];
    $marks_per_wrong_answer = $_POST['marks_per_wrong_answer'];

    $file_name = basename($_FILES["file"]["name"]);
    $file_tmp = $_FILES["file"]["tmp_name"];
    $upload_dir = __DIR__ . "/uploads/"; // Absolute path using __DIR__
    $upload_path = $upload_dir . $file_name;

    // Ensure the upload directory exists and is writable
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            die("Failed to create upload directory");
        }
    }

    if (is_writable($upload_dir)) {
        if (move_uploaded_file($file_tmp, $upload_path)) {
            $csv_data = array_map('str_getcsv', file($upload_path));

            // Establish database connection
            $conn = new mysqli($host, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the SQL statement for `all_subject_question_paper`
            $sql1 = "INSERT INTO all_subject_question_paper (admin_id, subject_id, exam_code, section_name, total_question, marks_per_right_answer, marks_per_wrong_answer, exam_subject_question_title, option_title_1, option_title_2, option_title_3, option_title_4, exam_subject_question_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);

            // Prepare the SQL statement for `subject_table`
            $sql2 = "INSERT INTO subject_table (admin_id, exam_code, section_name, total_question, marks_per_right_answer, marks_per_wrong_answer) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ssssss", $admin_id,  $exam_code, $section_name, $total_question, $marks_per_right_answer, $marks_per_wrong_answer);
            $stmt2->execute();

            // Retrieve the subject_id from the last insert to use in `all_subject_question_paper`
            $subject_id = $conn->insert_id;

            // Loop through CSV data and insert into `all_subject_question_paper`
            foreach ($csv_data as $row) {
                if (count($row) == 6) {
                    $exam_subject_question_title = $row[0];
                    $option_title_1 = $row[1];
                    $option_title_2 = $row[2];
                    $option_title_3 = $row[3];
                    $option_title_4 = $row[4];
                    $exam_subject_question_answer = $row[5];

                    $stmt1->bind_param("sssssssssssss", $admin_id, $subject_id, $exam_code, $section_name, $total_question, $marks_per_right_answer, $marks_per_wrong_answer, $exam_subject_question_title, $option_title_1, $option_title_2, $option_title_3, $option_title_4, $exam_subject_question_answer);
                    $stmt1->execute();
                }
            }

            $stmt1->close();
            $stmt2->close();
            $conn->close();

            echo '<script type="text/javascript">
                    alert("Exam added successfully");
                    window.location.href = "Online_Section_table.php";
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    alert("File upload failed: ' . htmlspecialchars($_FILES["file"]["error"]) . '");
                    console.log("Error detail: ' . print_r(error_get_last(), true) . '");
                  </script>';
        }
    } else {
        echo '<script type="text/javascript">
                alert("Upload directory is not writable");
                console.log("Directory permissions: ' . substr(sprintf('%o', fileperms($upload_dir)), -4) . '");
              </script>';
    }
}
?>
