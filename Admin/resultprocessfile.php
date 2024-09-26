<?php
include('../mainfile.php');
include('../Admin/Examination.php');

$exam = new Examination;

if ($_POST['action'] == 'fetch' && $_POST['page'] == 'calculation_result_datas') {
    $output = array();

    $query = "
    SELECT *, 
    CASE WHEN result_published = 1 THEN 'true' ELSE 'false' END AS result_processed 
    FROM online_exam_table 
    WHERE admin_id = ? 
    AND (
        online_exam_title LIKE ? 
        OR exam_code LIKE ? 
        OR online_exam_datetime LIKE ? 
        OR exam_result_publish_datetime LIKE ?
    )
    ";
    
    $search_value = '%' . $_POST["search"]["value"] . '%';
    $data = [$_SESSION["admin_id"], $search_value, $search_value, $search_value, $search_value];
    
    if (isset($_POST['order'])) {
        $query .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$$_POST['order']['0']['dir'].' ';
    } else {
        $query .= ' ORDER BY online_exam_id DESC ';
    }
    
    if ($_POST['length'] != -1) {
        $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    $exam->set_query($query, $data);
    $result = $exam->query_result();
    $filtered_rows = $exam->total_row();
    $total_rows = $exam->total_row("SELECT * FROM online_exam_table WHERE admin_id = ?", [$_SESSION["admin_id"]]);
    
    $data = array();
    
    foreach ($result as $row) {
        $sub_array = array();
        $sub_array['online_exam_title'] = html_entity_decode($row['online_exam_title']);
        $sub_array['exam_code'] = $row['exam_code'];
        $sub_array['online_exam_datetime'] = $row['online_exam_datetime'];
        $sub_array['exam_result_publish_datetime'] = $row['exam_result_publish_datetime'];
        $sub_array['result_processed'] = $row['result_processed'];
        
        $data[] = $sub_array;
    }
    
    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $total_rows,
        "recordsFiltered" => $filtered_rows,
        "data" => $data
    );
    
    echo json_encode($output);
}

if ($_POST['action'] == 'fetch_results' && isset($_POST['exam_code'])) {
    $exam_code = $_POST['exam_code'];
    $query = "
    SELECT * FROM calculation_result_data 
    WHERE exam_code = ?
    ";
    
    $exam->set_query($query, [$exam_code]);
    $result = $exam->query_result();
    $data = array();
    
    foreach ($result as $row) {
        $sub_array = array();
        $sub_array['exam_code'] = $row['exam_code'];
        $sub_array['enrollment_number'] = $row['enrollment_number'];
        $sub_array['exam_name'] = $row['exam_name'];
        $sub_array['time'] = $row['time'];
        $sub_array['total_question'] = $row['total_question'];
        $sub_array['maximum_marks'] = $row['maximum_marks'];
        $sub_array['negative_marks'] = $row['negative_marks'];
        $sub_array['total_marks'] = $row['total_marks'];
        $sub_array['marks'] = $row['marks'];
        $sub_array['attendance_status'] = $row['attendance_status'];
        $sub_array['percentage'] = $row['percentage'];
        
        $data[] = $sub_array;
    }
    
    $output = array(
        "data" => $data
    );
    
    echo json_encode($output);
}

if ($_POST['action'] == 'process_result' && isset($_POST['exam_code'])) {
    $exam_code = $_POST['exam_code'];
    $admin_id = $_SESSION["admin_id"];
    
    // Your result processing logic here
    // ...

    // After processing, update the result_published to 1
    $query = "
    UPDATE online_exam_table 
    SET result_published = 1 
    WHERE exam_code = ? AND admin_id = ?
    ";
    
    $exam->set_query($query, [$exam_code, $admin_id]);
    $exam->execute_query();

    echo 'success';
}

?>
