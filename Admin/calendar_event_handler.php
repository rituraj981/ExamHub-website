<?php
include '../mainfile.php';

session_start();

// Function to display events
function display_events($conn) {
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
        
        // Query for events from calendar_event_master
        $calendar_event_query = "
            SELECT 
                event_id, 
                event_name, 
                event_start_date, 
                event_end_date 
            FROM 
                calendar_event_master 
            WHERE 
                admin_id = '$admin_id'
        ";
        
        // Query for events from online_exam_table
        $online_exam_query = "
            SELECT 
                admin_id, 
                online_exam_title, 
                online_exam_datetime, 
                exam_result_publish_datetime 
            FROM 
                online_exam_table 
            WHERE 
                admin_id = '$admin_id'
        ";
        
        $calendar_results = mysqli_query($conn, $calendar_event_query);
        $exam_results = mysqli_query($conn, $online_exam_query);
        
        $data_arr = array();
        $i = 0;
        
        // Process calendar_event_master results
        while ($data_row = mysqli_fetch_array($calendar_results, MYSQLI_ASSOC)) {
            $data_arr[$i]['event_id'] = $data_row['event_id'];
            $data_arr[$i]['title'] = $data_row['event_name'];
            $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['event_start_date']));
            $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['event_end_date']));
            $data_arr[$i]['color'] = '#'.substr(uniqid(), -6); // Generate a random color
            $data_arr[$i]['url'] = '';
            $i++;
        }
        
        // Process online_exam_table results
        while ($data_row = mysqli_fetch_array($exam_results, MYSQLI_ASSOC)) {
            // Online exam event
            $data_arr[$i]['event_id'] = $data_row['admin_id']; // Assuming admin_id as event_id for uniqueness
            $data_arr[$i]['title'] = $data_row['online_exam_title'];
            $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['online_exam_datetime']));
            $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['online_exam_datetime'])); // Assuming start and end date are the same
            $data_arr[$i]['color'] = '#'.substr(uniqid(), -6); // Generate a random color
            $data_arr[$i]['url'] = '';
            $i++;
            
            // Result publish event
            $result_publish_date = date("Y-m-d", strtotime($data_row['exam_result_publish_datetime']));
            $data_arr[$i]['event_id'] = $data_row['admin_id']; // Assuming admin_id as event_id for uniqueness
            $data_arr[$i]['title'] = $data_row['online_exam_title'] . " - Result Published";
            $data_arr[$i]['start'] = $result_publish_date;
            $data_arr[$i]['end'] = $result_publish_date;
            $data_arr[$i]['color'] = '#'.substr(uniqid(), -6); // Generate a random color
            $data_arr[$i]['url'] = '';
            $i++;
        }
        
        // Check if data array is not empty
        if (count($data_arr) > 0) {
            $data = array(
                'status' => true,
                'msg' => 'Successfully retrieved events!',
                'data' => $data_arr
            );
        } else {
            $data = array(
                'status' => false,
                'msg' => 'No events found!'
            );
        }
        
        echo json_encode($data);
    } else {
        echo json_encode(array('status' => false, 'msg' => 'Unauthorized access.'));
    }
}


// Function to save or update events
function save_or_update_event($conn) {
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
        $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
        $event_name = $_POST['event_name'];
        $event_start_date = date("Y-m-d", strtotime($_POST['event_start_date']));
        $event_end_date = date("Y-m-d", strtotime($_POST['event_end_date']));

        if ($event_id) {
            // Update existing event
            $update_query = "UPDATE `calendar_event_master` SET `event_name` = '$event_name', `event_start_date` = '$event_start_date', `event_end_date` = '$event_end_date' WHERE `event_id` = '$event_id' AND `admin_id` = '$admin_id'";
            if (mysqli_query($conn, $update_query)) {
                $data = array(
                    'status' => true,
                    'msg' => 'Event updated successfully!'
                );
            } else {
                $data = array(
                    'status' => false,
                    'msg' => 'Sorry, Event not updated.'
                );
            }
        } else {
            // Save new event
            $insert_query = "INSERT INTO `calendar_event_master`(`event_name`, `event_start_date`, `event_end_date`, `admin_id`) VALUES ('$event_name', '$event_start_date', '$event_end_date', '$admin_id')";
            if (mysqli_query($conn, $insert_query)) {
                $data = array(
                    'status' => true,
                    'msg' => 'Event added successfully!'
                );
            } else {
                $data = array(
                    'status' => false,
                    'msg' => 'Sorry, Event not added.'
                );
            }
        }
        echo json_encode($data);
    } else {
        echo json_encode(array('status' => false, 'msg' => 'Unauthorized access.'));
    }
}

// Function to delete events
function delete_event($conn) {
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];
        $event_id = $_POST['event_id'];

        $delete_query = "DELETE FROM `calendar_event_master` WHERE `event_id` = '$event_id' AND `admin_id` = '$admin_id'";
        if (mysqli_query($conn, $delete_query)) {
            $data = array(
                'status' => true,
                'msg' => 'Event deleted successfully!'
            );
        } else {
            $data = array(
                'status' => false,
                'msg' => 'Sorry, Event not deleted.'
            );
        }
        echo json_encode($data);
    } else {
        echo json_encode(array('status' => false, 'msg' => 'Unauthorized access.'));
    }
}

// Main handler
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'display':
            display_events($conn);
            break;
        case 'save_or_update':
            save_or_update_event($conn);
            break;
        case 'delete':
            delete_event($conn);
            break;
        default:
            echo json_encode(array('status' => false, 'msg' => 'Invalid action.'));
            break;
    }
} else {
    echo json_encode(array('status' => false, 'msg' => 'No action specified.'));
}
?>
