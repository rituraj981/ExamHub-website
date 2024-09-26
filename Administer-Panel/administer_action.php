<?php

//ajax_action.php

include('../Admin/Examination.php');


require_once('../class/class.phpmailer.php');
    
$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{

    if ($_POST['page'] == 'view_user_data') {
        if ($_POST['action'] == 'fetch') {
            $output = array();
    
            // Fetching the exam_code from administer_table
            $exam->query = "SELECT exam_code FROM administer_table WHERE administer_id = ?";
            $stmt = $exam->connect->prepare($exam->query);
            $stmt->execute([$_SESSION['administer_id']]);
            $administer_data = $stmt->fetch();
            $exam_code = $administer_data['exam_code'];
    
            // Preparing the user query with filtering by exam_code
            $exam->query = "
                SELECT `user_id`, `user_email_address`, `user_password`, `enrollment_number`, `user_exam_code`, 
                       `user_verfication_code`, `user_mobile_no`, `user_name`, `user_gender`, `user_image`, 
                       `user_created_on`, `user_email_verified`
                FROM `user_table`
                WHERE `user_exam_code` = ?
            ";
    
            // Additional filtering based on search
            if (isset($_POST['search']['value'])) {
                $exam->query .= ' AND (user_name LIKE ? ';
                $exam->query .= 'OR user_mobile_no LIKE ? ';
                $exam->query .= 'OR user_email_address LIKE ? ';
                $exam->query .= 'OR user_gender LIKE ? ';
                $exam->query .= 'OR enrollment_number LIKE ? ';
                $exam->query .= 'OR user_email_verified LIKE ? )';
            }
    
            // Ordering
            if (isset($_POST['order'])) {
                $exam->query .= ' ORDER BY ' . $_POST['order'][0]['column'] . ' ' . $_POST['order'][0]['dir'] . ' ';
            } else {
                $exam->query .= ' ORDER BY user_id ASC ';
            }
    
            // Limit for pagination
            $extra_query = '';
            if ($_POST['length'] != -1) {
                $extra_query = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }
    
            $stmt = $exam->connect->prepare($exam->query . $extra_query);
    
            // Bind parameters
            $bind_params = [$exam_code];
            if (isset($_POST['search']['value'])) {
                $search_value = '%' . $_POST['search']['value'] . '%';
                $bind_params = array_merge($bind_params, array_fill(0, 6, $search_value));
            }
    
            $stmt->execute($bind_params);
            $result = $stmt->fetchAll();
            $filtered_rows = $stmt->rowCount();
    
            // Total rows without filtering
            $exam->query = "SELECT COUNT(*) FROM `user_table` WHERE `user_exam_code` = ?";
            $stmt = $exam->connect->prepare($exam->query);
            $stmt->execute([$exam_code]);
            $total_rows = $stmt->fetchColumn();
    
            $data = array();
            foreach ($result as $row) {
                $sub_array = array();
                $sub_array[] = "<img src='../Student/upload/" . $row["user_image"] . "' class='img-thumbnail' width='55' />";
                $sub_array[] = $row["user_name"];
                $sub_array[] = $row["enrollment_number"];
                $sub_array[] = $row["user_exam_code"];
                $sub_array[] = $row["user_email_address"];
                $sub_array[] = $row["user_gender"];
                $sub_array[] = $row["user_mobile_no"];
                $status_button = '<button class="status-button btn btn-sm ' . ($row["user_email_verified"] == 'Yes' ? 'btn-primary' : 'btn-danger') . '" data-user-id="' . $row["user_id"] . '" data-status="' . $row["user_email_verified"] . '">' . ($row["user_email_verified"] == 'Yes' ? 'Present' : 'Absent') . '</button>';
                $sub_array[] = $status_button;
    
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
    
    }
    

    
}
?>