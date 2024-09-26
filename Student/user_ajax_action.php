<?php

//user_ajax_action.php

include('../Admin/Examination.php');

require_once('../class/class.phpmailer.php');

$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query ="SELECT * FROM user_table 
			WHERE user_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email_address'];

			$exam->filedata = $_FILES['user_image'];

			$user_image = $exam->Upload_file();

			$exam->data = array(
				':user_email_address'	=>	$receiver_email,
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':enrollment_number'	=>	$_POST['enrollment_number'],
				':user_exam_code'		=>	$_POST['user_exam_code'],
				':user_gender'			=>	$_POST['user_gender'],
				':user_mobile_no'		=>	$_POST['user_mobile_no'],
				':user_image'			=>	$user_image,
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "INSERT INTO user_table 
			(user_email_address, user_password, user_verfication_code, user_name, enrollment_number, user_exam_code, user_gender, user_mobile_no, user_image, user_created_on)
			VALUES 
			(:user_email_address, :user_password, :user_verfication_code, :user_name, :enrollment_number, :user_exam_code, :user_gender, :user_mobile_no, :user_image, :user_created_on)
			";

			$exam->execute_query();

			$subject= 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=user&code='.$user_verfication_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);

			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = :user_email_address
			";

			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();

				foreach($result as $row)
				{
					if($row['user_email_verified'] == 'Yes')
					{
						if(password_verify($_POST['user_password'], $row['user_password']))
						{
							$_SESSION['user_id'] = $row['user_id'];

							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'		=>	'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'		=>	'Wrong Email Address'
				);
			}

			echo json_encode($output);
		}
	}

	// if($_POST['page'] == "profile")
	// {
	// 	if($_POST['action'] == "profile")
	// 	{
	// 		$user_image = $_POST['hidden_user_image'];

	// 		if($_FILES['user_image']['name'] != '')
	// 		{
	// 			$exam->filedata = $_FILES['user_image'];

	// 			$user_image = $exam->Upload_file();
	// 		}

	// 		$exam->data = array(
	// 			':user_name'				=>	$exam->clean_data($_POST['user_name']), 
	// 			':user_gender'				=>	$_POST['user_gender'],
	// 			// ':user_address'				=>	$exam->clean_data($_POST['user_address']),
	// 			':user_mobile_no'			=>	$_POST['user_mobile_no'],
	// 			':user_image'				=>	$user_image,
	// 			':user_id'					=>	$_SESSION['user_id']		
	// 		);

	// 		$exam->query = "
	// 		UPDATE user_table 
	// 		SET user_name = :user_name, user_gender = :user_gender, user_address = :user_address, user_mobile_no = :user_mobile_no, user_image = :user_image 
	// 		WHERE user_id = :user_id
	// 		";
	// 		$exam->execute_query();

	// 		$output = array(
	// 			'success'		=>	true
	// 		);

	// 		echo json_encode($output);

	// 	}
	// }

	// if($_POST['page'] == 'change_password')
	// {
	// 	if($_POST['action'] == 'change_password')
	// 	{
	// 		$exam->data = array(
	// 			':user_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
	// 			':user_id'			=>	$_SESSION['user_id']
	// 		);

	// 		$exam->query = "
	// 		UPDATE user_table 
	// 		SET user_password = :user_password 
	// 		WHERE user_id = :user_id
	// 		";

	// 		$exam->execute_query();

	// 		session_destroy();

	// 		$output = array(
	// 			'success'		=>	'Password has been change'
	// 		);

	// 		echo json_encode($output);
	// 	}
	// }

	// if($_POST['page'] == 'index')
	// {
	// 	if($_POST['action'] == "fetch_exam")
	// 	{
	// 		$exam->query = "SELECT * FROM online_exam_table 
	// 		WHERE online_exam_id = '".$_POST['exam_id']."'
	// 		";

	// 		$result = $exam->query_result();

	// 		$output = '
	// 		<div class="card">
	// 			<div class="card-header">Exam Details</div>
	// 			<div class="card-body">
	// 				<table class="table table-striped table-hover table-bordered">
	// 		';
	// 		foreach($result as $row)
	// 		{
	// 			$output .= '
	// 			<tr>
	// 				<td><b>Exam Title</b></td>
	// 				<td>'.$row["online_exam_title"].'</td>
	// 			</tr>
	// 			<tr>
	// 				<td><b>Exam Date & Time</b></td>
	// 				<td>'.$row["online_exam_datetime"].'</td>
	// 			</tr>
	// 			<tr>
	// 				<td><b>Exam Duration</b></td>
	// 				<td>'.$row["online_exam_duration"].' Minute</td>
	// 			</tr>
	// 			<tr>
	// 				<td><b>Exam Total Question</b></td>
	// 				<td>'.$row["total_question"].' Question </td>
	// 			</tr>
	// 			<tr>
	// 				<td><b>Marks Per Right Answer</b></td>
	// 				<td>'.$row["marks_per_right_answer"].' Mark</td>
	// 			</tr>
	// 			<tr>
	// 				<td><b>Marks Per Wrong Answer</b></td>
	// 				<td>-'.$row["marks_per_wrong_answer"].' Mark</td>
	// 			</tr>
	// 			';
	// 			if($exam->If_user_already_enroll_exam($_POST['exam_id'], $_SESSION['user_id']))
	// 			{
	// 				$enroll_button = '
	// 				<tr>
	// 					<td colspan="2" align="center">
	// 						<button type="button" name="enroll_button" class="btn btn-info">You Already Enroll it</button>
	// 					</td>
	// 				</tr>
	// 				';
	// 			}
	// 			else
	// 			{
	// 				$enroll_button = '
	// 				<tr>
	// 					<td colspan="2" align="center">
	// 						<button type="button" name="enroll_button" id="enroll_button" class="btn btn-warning" data-exam_id="'.$row['online_exam_id'].'">Enroll it</button>
	// 					</td>
	// 				</tr>
	// 				';
	// 			}
				
	// 			$output .= $enroll_button;
				
	// 		}
	// 		$output .= '</table>';
	// 		echo $output;
	// 	}


	if ($_POST['action'] == 'enroll_exam') 
	{
		$exam_id = $_POST['exam_id'];
		$user_id = $_SESSION['user_id'];
	
		$query = "INSERT INTO user_exam_enroll_table (user_id, exam_id) VALUES (:user_id, :exam_id)";
		$statement = $exam->connect->prepare($query);
	
		$statement->bindParam(':user_id', $user_id);
		$statement->bindParam(':exam_id', $exam_id);
	
		if ($statement->execute()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to enroll']);
		}
	}


	
}

?>