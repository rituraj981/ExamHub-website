<?php

//ajax_action.php

include('Examination.php');


require_once('../class/class.phpmailer.php');

$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = " SELECT * FROM admin_table 
			WHERE admin_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$admin_verification_code = md5(rand());

			$receiver_email = $_POST['admin_email_address'];

			$exam->data = array(
				':admin_name'			    =>	$_POST['admin_name'],
				':admin_email_address'		=>	$receiver_email,
				':admin_password'			=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'	=>	$admin_verification_code,
				':admin_type'				=>	'Master Admin', 
				':admin_created_on'			=>	$current_datetime
			);

			$exam->query = " INSERT INTO admin_table 
			(admin_name, admin_email_address, admin_password, admin_verfication_code, admin_type, admin_created_on) 
			VALUES 
			(:admin_name, :admin_email_address, :admin_password, :admin_verfication_code, :admin_type, :admin_created_on)
			";

			$exam->execute_query();

			$subject = 'BharatExamHub.com Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=master&code='.$admin_verification_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>BharatExamHub.com</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':admin_email_address' => $_POST['admin_email_address']
			);

			// First check admin_table
			$exam->query = "SELECT * FROM admin_table WHERE admin_email_address = :admin_email_address";
			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();
				foreach($result as $row)
				{
					if($row['email_verified'] == 'Yes')
					{
						if(password_verify($_POST['admin_password'], $row['admin_password']))
						{
							$_SESSION['admin_id'] = $row['admin_id'];
							$output = array(
								'success' => true,
								'redirect_url' => 'index.php'
							);
						}
						else
						{
							$output = array(
								'error' => 'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error' => 'Your Email is not verified'
						);
					}
				}
			}
			else
			{
				// If not found in admin_table, check administer_table
				$exam->query = "SELECT * FROM administer_table WHERE administer_email_address = :admin_email_address";
				$total_row = $exam->total_row();

				if($total_row > 0)
				{
					$result = $exam->query_result();
					foreach($result as $row)
					{
						if($row['administer_email_verified'] == 'Yes')
						{
							if(password_verify($_POST['admin_password'], $row['administer_password']))
							{
								$_SESSION['administer_id'] = $row['administer_id'];
								if($row['administer_type'] == 'Administer')
								{
									$output = array(
										'success' => true,
										'redirect_url' => '../Administer-Panel/administer_panel.php'
									);
								}
								else if($row['administer_type'] == 'Examiner')
								{
									$output = array(
										'success' => true,
										'redirect_url' => '../Administer-Panel/examiner_panel.php'
									);
								}
							}
							else
							{
								$output = array(
									'error' => 'Wrong Password'
								);
							}
						}
						else
						{
							$output = array(
								'error' => 'Your Email is not verified'
							);
						}
					}
				}
				else
				{
					$output = array(
						'error' => 'Wrong Email Address'
					);
				}
			}
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR question_type LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_status LIKE "%'.$_POST["search"]["value"].'%" ';

			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['online_exam_title']);
				$sub_array[] = $row['online_exam_datetime'];
				$sub_array[] = $row['online_exam_duration'] . ' Minute';
				$sub_array[] = $row['total_question'] . ' Question';
				$sub_array[] = $row['marks_per_right_answer'] . ' Mark';
				$sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Mark';
				$sub_array[] =  $row['question_type'];


				$edit_delete = '';
				// $status = '';
				$edit_button = '';
				$delete_button = '';
				// $question_button = '';
				// $result_button = '';

				// if($row['online_exam_status'] == 'Pending')
				// {
				// 	$status = '<span class="badge badge-warning">Pending</span>';
				// }

				// if($row['online_exam_status'] == 'Created')
				// {
				// 	$status = '<span class="badge badge-success">Created</span>';
				// }

				// if($row['online_exam_status'] == 'Started')
				// {
				// 	$status = '<span class="badge badge-primary">Started</span>';
				// }

				// if($row['online_exam_status'] == 'Completed')
				// {
				// 	$status = '<span class="badge badge-dark">Completed</span>';
				// }

				if($exam->Is_exam_is_not_started($row["online_exam_id"]))
				{
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="' . $row['online_exam_id'] . '">Edit</button>';

					$delete_button = '<button type="button" name="delete" class=" btn-danger btn-sm delete" id="'.$row['online_exam_id'].'">Delete</button>';

				}
				else
				{	
					$result_button = '<a href="exam_result.php?code='.$row["online_exam_code"].'" class="btn btn-dark btn-sm">Result</a>';
				}

				if($exam->Is_allowed_add_question($row['online_exam_id']))
				{
					$question_button = '
					<button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="'.$row['online_exam_id'].'">Add Question</button>
					';
				}
				else
				{
					$question_button = '
					<a href="question_paper.php?code='.$row['online_exam_code'].'" class="btn btn-warning btn-sm">View Question</a>';
				}

				// $sub_array[] = $status;
				// $sub_array[] = $edit_delete;

				// $sub_array[] = $question_button;

				// $sub_array[] = $result_button;

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);

		}

		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':admin_id'					=>	$_SESSION['admin_id'],
				':online_exam_title'		=>	$exam->clean_data($_POST['online_exam_title']),
				':exam_code'				=>	$_POST['exam_code'],
				':online_exam_datetime'		=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'		=>	$_POST['online_exam_duration'],
				':total_question'			=>	$_POST['total_question'],
				':marks_per_right_answer'	=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'	=>	$_POST['marks_per_wrong_answer'],
				':question_type'		 	=>	$_POST['question_type'],
				':online_exam_created_on'	=>	$current_datetime,
				':online_exam_status'		=>	'Pending',
				':online_exam_code'			=>	md5(rand())
			);

			$exam->query = "INSERT INTO online_exam_table 
			(admin_id, online_exam_title, exam_code, online_exam_datetime, online_exam_duration, total_question, marks_per_right_answer, marks_per_wrong_answer, question_type, online_exam_created_on, online_exam_status, online_exam_code) 
			VALUES (:admin_id, :online_exam_title, :exam_code, :online_exam_datetime, :online_exam_duration, :total_question, :marks_per_right_answer, :marks_per_wrong_answer, :question_type, :online_exam_created_on, :online_exam_status, :online_exam_code)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'New Exam Details Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch')
		{
			$exam->query = "SELECT * FROM online_exam_table 
			WHERE online_exam_id = '".$_POST["exam_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['online_exam_title'] = $row['online_exam_title'];

				$output['exam_code'] = $row['exam_code'];

				$output['online_exam_datetime'] = $row['online_exam_datetime'];

				$output['online_exam_duration'] = $row['online_exam_duration'];

				$output['total_question'] = $row['total_question'];

				$output['marks_per_right_answer'] = $row['marks_per_right_answer'];

				$output['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];

				$output['question_type'] = $row['question_type'];

			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':online_exam_title'	=>	$_POST['online_exam_title'],
				':exam_code'			 => $_POST['exam_code'],
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_id'		=>	$_POST['online_exam_id'],
				':question_type' 		=> $_POST['question_type']
			);

			$exam->query = "UPDATE online_exam_table 
			SET online_exam_title = :online_exam_title,
				exam_code = :exam_code,
			 	online_exam_datetime = :online_exam_datetime,
			  	online_exam_duration = :online_exam_duration,
			   	total_question = :total_question,
			    marks_per_right_answer = :marks_per_right_answer, 
				marks_per_wrong_answer = :marks_per_wrong_answer,
				question_type = :question_type  
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Exam Details has been changed'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':online_exam_id'	=>	$_POST['exam_id']
			);

			$exam->query = "
			DELETE FROM online_exam_table 
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'show_section_data') 
	{
		if ($_POST['action'] == 'fetch') 
		{
			if (isset($_SESSION['admin_id'])) 
			{
				$admin_id = $_SESSION['admin_id'];
	
				$output = array();
	
				$exam->query = "SELECT * FROM subject_table 
								WHERE admin_id = '".$admin_id."' ";
	
				if (isset($_POST['search']['value'])) {
					$exam->query .= 'AND (exam_code LIKE "%'.$_POST["search"]["value"].'%" ';
					$exam->query .= 'OR section_name LIKE "%'.$_POST["search"]["value"].'%" ';
					$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';
					$exam->query .= 'OR marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';
					$exam->query .= 'OR marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%") ';
				}
	
				if (isset($_POST['order'])) {
					$exam->query .= 'ORDER BY '.$_POST['columns'][$_POST['order'][0]['column']]['data'].' '.$_POST['order'][0]['dir'].' ';
				} else {
					$exam->query .= 'ORDER BY subject_id DESC ';
				}
	
				if ($_POST['length'] != -1) {
					$exam->query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
				}
	
				$filtered_rows = $exam->total_row();
				$result = $exam->query_result();
				$data = array();
	
				foreach ($result as $row) {
					$sub_array = array();
					$sub_array[] = html_entity_decode($row['exam_code']);
					$sub_array[] = $row['section_name'];
					$sub_array[] = $row['total_question'] . ' Question';
					$sub_array[] = $row['marks_per_right_answer'] . ' Mark';
					$sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Mark';
	
					$question_button = '<a href="Online_question_paper.php?subject_id='.$row['subject_id'].'" class="btn btn-warning btn-sm">View Question</a>';
	
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['subject_id'].'">Edit</button>';
					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['subject_id'].'">Delete</button>';
	
					$sub_array[] = $question_button;
					$sub_array[] = $edit_button . ' ' . $delete_button;
	
					$data[] = $sub_array;
				}
	
				$output = array(
					"draw"              => intval($_POST["draw"]),
					"recordsTotal"      => $filtered_rows, // Using filtered_rows since we're not paginating the whole dataset
					"recordsFiltered"   => $filtered_rows,
					"data"              => $data
				);
	
				echo json_encode($output);
			}
		}
		
		if($_POST['action'] == 'delete') 
		{
			$exam->data = array(
				':subject_id'   => $_POST['exam_id']
			);

			$exam->query = "DELETE FROM subject_table 
							WHERE subject_id = :subject_id";

			$exam->execute_query($exam->data); // Pass the data array to execute_query

			$output = array(
				'success' => 'Exam Details have been removed'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'View_exam_details')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR exam_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR exam_result_publish_datetime LIKE "%'.$_POST["search"]["value"].'%" ';

			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();
			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['online_exam_title']);
				$sub_array[] = $row['total_question'] . ' Question';
				$sub_array[] = $row['online_exam_datetime'];
				$sub_array[] = $row['exam_result_publish_datetime'];
				$sub_array[] = $row['exam_code'];

				$status = '';
				$edit_button = '';
				$delete_button = '';
				// $question_button = '';
				$publish_button = '';
				$result_button = '';

				if($row['online_exam_status'] == 'Pending')
				{
					$status = '<span class="badge badge-warning">Pending</span>';
				}

				if($row['online_exam_status'] == 'Created')
				{
					$status = '<span class="badge badge-success">Created</span>';
				}

				if($row['online_exam_status'] == 'Started')
				{
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if($row['online_exam_status'] == 'Completed')
				{
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				if($exam->Is_exam_is_not_started($row["online_exam_id"]))
				{
					$edit_button = '
					<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['online_exam_id'].'">Edit</button>
					';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['online_exam_id'].'">Delete</button>';

				}
				else
				{
					$publish_button = '<button class="btn btn-warning btn-sm publish_result" data-exam_id="'.$row['online_exam_id'].'">Publish Result</button>';
					
					$result_button = '<a href="Exam_result_panel.php?exam_code='.$row['exam_code'].'" class="btn btn-dark btn-sm">View Result</a>';
				}


				// if($exam->Is_allowed_add_question($row['online_exam_id']))
				// {
				// 	$question_button = '
				// 	<button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="'.$row['online_exam_id'].'">View Question</button>
				// 	';
				// }
				// else
				// {
				// 	$question_button = '
				// 	<a href="question.php?code='.$row['online_exam_code'].'" class="btn btn-warning btn-sm">View Question</a>
				// 	';
				// }

				$sub_array[] = $status;
				// $sub_array[] = $question_button;
				$sub_array[] = $publish_button . ' ' . $result_button;			
				$sub_array[] = $edit_button . ' ' . $delete_button;
				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);

		}

		if ($_POST['action'] == 'fetch_result_publish_data')
		{
			// Fetch existing publish datetime
			$exam_id = $_POST['exam_id'];
			$query = "SELECT exam_result_publish_datetime FROM online_exam_table WHERE online_exam_id = :exam_id";
			$statement = $pdo->prepare($query);
			$statement->execute([':exam_id' => $exam_id]);
			$result = $statement->fetch(PDO::FETCH_ASSOC);

			echo $result['exam_result_publish_datetime'];
		}

		if ($_POST['action'] == 'Result Publish') {
			// Update publish datetime
			$exam_id = $_POST['hidden_exam_id'];
			$publish_datetime = $_POST['exam_result_publish_datetime'];
			$query = "UPDATE online_exam_table SET exam_result_publish_datetime = :publish_datetime WHERE online_exam_id = :exam_id";
			$statement = $pdo->prepare($query);
			$statement->execute([
				':publish_datetime' => $publish_datetime,
				':exam_id' => $exam_id
			]);
	
			$response = array(
				'success' => '<div class="alert alert-success">Exam Result Publish Date & Time updated successfully</div>'
			);
			echo json_encode($response);
		}
	}

	if ($_POST['page'] == 'view_section_wise_question') 
	{
		if ($_POST['action'] == 'fetch') 
		{
			$subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : '';
	
			$output = array();
	
			$exam->query = "SELECT * FROM all_subject_question_paper WHERE subject_id = ? AND admin_id = '".$_SESSION["admin_id"]."' ";
	
			if (isset($_POST['search']['value'])) {
				$exam->query .= 'AND (exam_code LIKE ? OR section_name LIKE ? OR exam_subject_question_title LIKE ? OR option_title_1 LIKE ? OR option_title_2 LIKE ? OR option_title_3 LIKE ? OR option_title_4 LIKE ?)';
			}
	
			if (isset($_POST['order'])) {
				$exam->query .= ' ORDER BY '.$_POST['columns'][$_POST['order'][0]['column']]['data'].' '.$_POST['order'][0]['dir'].' ';
			} else {
				$exam->query .= ' ORDER BY question_id DESC ';
			}
	
			// Limit
			if ($_POST['length'] != -1) {
				$exam->query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
	
			// Prepare and execute the statement
			try {
				$stmt = $exam->connect->prepare($exam->query);
	
				// Bind parameters
				$bind_params = [$subject_id];
				if (isset($_POST['search']['value'])) {
					$search_value = '%'.$_POST['search']['value'].'%';
					$bind_params = array_merge($bind_params, array_fill(0, 7, $search_value));
				}
	
				// Debugging: Output the query and parameters
				error_log("SQL Query: " . $exam->query);
				error_log("Bind Parameters: " . json_encode($bind_params));
	
				$stmt->execute($bind_params);
	
				$filtered_rows = $stmt->rowCount();
				$result = $stmt->fetchAll();
	
				$data = array();
	
				foreach ($result as $row) {
					$sub_array = array();
					$sub_array[] = html_entity_decode($row['exam_code']);
					$sub_array[] = $row['section_name'];
					$sub_array[] = $row['exam_subject_question_title'];
					$sub_array[] = $row['option_title_1'];
					$sub_array[] = $row['option_title_2'];
					$sub_array[] = $row['option_title_3'];
					$sub_array[] = $row['option_title_4'];
	
					// Add edit and delete buttons
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['question_id'].'">Edit</button>';
					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['question_id'].'">Delete</button>';
	
					$sub_array[] = $edit_button . ' ' . $delete_button;
	
					$data[] = $sub_array;
				}
	
				$output = array(
					"draw"              => intval($_POST["draw"]),
					"recordsTotal"      => $filtered_rows,
					"recordsFiltered"   => $filtered_rows,
					"data"              => $data
				);
	
				echo json_encode($output);
			} catch (PDOException $e) {
				error_log("Error: " . $e->getMessage());
				echo json_encode(array("error" => "Database query error"));
			}
		}
	
	
		if($_POST['action'] == 'edit_fetch')
		{
			$exam->data = array(
				':admin_id'         => $_SESSION['admin_id'],
				':exam_name'        => $exam->clean_data($_POST['exam_code']),
				':section_name'     => $_POST['section_name'],
				':total_question'   => $_POST['total_question'],
				':subject_id'       => $_POST['subject_id'] // Make sure to include subject_id
			);

			$exam->query = "UPDATE subject_table 
							SET exam_code = :exam_code, section_name = :section_name, total_question = :total_question  
							WHERE subject_id = :subject_id";

			$exam->execute_query($exam->data);

			$output = array(
				'success' => 'Exam Details have been changed'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete') 
		{
			$exam->data = array(
				':question_id'   => $_POST['exam_id']
			);

			$exam->query = "DELETE FROM all_subject_question_paper  
							WHERE question_id = :question_id";

			$exam->execute_query($exam->data); // Pass the data array to execute_query

			$output = array(
				'success' => 'Exam Details have been removed'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam_result')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();
			$exam_id = $exam->Get_exam_id($_POST["code"]);
			
			$exam->query = "SELECT user_table.user_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= '
			) 
			GROUP BY user_exam_question_answer.user_id 
			';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY total_mark DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "SELECT 	user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			GROUP BY user_exam_question_answer.user_id 
			ORDER BY total_mark DESC
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $exam->Get_user_exam_status($exam_id, $row["user_id"]);
				$sub_array[] = $row["total_mark"];
				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}

	if ($_POST['page'] == 'view_user_data') 
	{
		if ($_POST['action'] == 'fetch') 
		{
			$output = array();
			$exam_code = $_POST['exam_code'];
	
			$exam->query = "SELECT u.`user_id`, u.`user_email_address`, u.`user_password`, u.`user_exam_code`, 
							u.`enrollment_number`, u.`user_mobile_no`, u.`user_name`, u.`user_gender`, 
							u.`user_image`, u.`user_created_on`, u.`user_email_verified` 
							FROM `user_table` u
							INNER JOIN `online_exam_table` o 
							ON u.`user_exam_code` = o.`exam_code`
							WHERE u.`user_exam_code` = ? ";
	
			if (isset($_POST['search']['value'])) {
				$exam->query .= 'AND (user_name LIKE ? ';
				$exam->query .= 'OR user_mobile_no LIKE ? ';
				$exam->query .= 'OR user_email_address LIKE ? ';
				$exam->query .= 'OR user_gender LIKE ? ';
				$exam->query .= 'OR enrollment_number LIKE ? ';
				$exam->query .= 'OR user_email_verified LIKE ? )';
			}
	
			if (isset($_POST['order'])) {
				$exam->query .= 'ORDER BY ' . $_POST['order'][0]['column'] . ' ' . $_POST['order'][0]['dir'] . ' ';
			} else {
				$exam->query .= 'ORDER BY user_id ASC ';
			}
	
			$extra_query = '';
			if ($_POST['length'] != -1) {
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
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
			$exam->query = "SELECT COUNT(*) FROM `user_table` u
							INNER JOIN `online_exam_table` o 
							ON u.`user_exam_code` = o.`exam_code`
							WHERE u.`user_exam_code` = ?";
			$stmt = $exam->connect->prepare($exam->query);
			$stmt->execute([$exam_code]);
			$total_rows = $stmt->fetchColumn();
	
			$data = array();
			foreach ($result as $row) {
				$sub_array = array();
				$sub_array[] = "<img src='../Student/upload/" . $row["user_image"] . "' class='img-thumbnail' width='75' />";
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["enrollment_number"];
				$sub_array[] = $row["user_exam_code"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["user_gender"];
				$sub_array[] = $row["user_mobile_no"];
				$is_email_verified = ($row['user_email_verified'] == 'Yes') ? '<label class="badge badge-success">Yes</label>' : '<label class="badge badge-danger">No</label>';
				$sub_array[] = $is_email_verified;
	
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

	if($_POST['page'] == 'add_administer_examiner_data')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "SELECT * FROM administer_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'administer_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR exam_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR administer_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR administer_type LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR administer_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR administer_email_verified LIKE "%'.$_POST["search"]["value"].'%" ';

			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY administer_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "SELECT * FROM administer_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['administer_name']);
				$sub_array[] = $row['exam_code'];
				$sub_array[] = $row['administer_email_address'];
				$sub_array[] = $row['administer_type'];
				$sub_array[] = $row['administer_created_on'];
				$sub_array[] = $row['administer_email_verified'];

				// $edit_button = '';
				$delete_button = '';
				
				// $edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['administer_id'].'">Edit</button>';
				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['administer_id'].'">Delete</button>';

				$sub_array[] = $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);

		}

		// if($_POST['action'] == 'Add') 
		// {
		// 	$exam->data = array(
		// 		':admin_id'						=>	$_SESSION['admin_id'],
		// 		':administer_name'				=>	$exam->clean_data($_POST['administer_name']),
		// 		':exam_code'					=>	$_POST['exam_code'],
		// 		':administer_email_address' 	=> $_POST['administer_email_address'],
		// 		':administer_password'			=>	password_hash($_POST['administer_password'], PASSWORD_DEFAULT),
		// 		':administer_verfication_code'	=>	md5(rand()),
		// 		':administer_created_on'		=>	$current_datetime,
		// 		':administer_type' 				=> $_POST['administer_type'],
		// 		':adminiset_email_verified' 	=> $_POST['adminiset_email_verified']
		// 	);
		// 	$exam->query = "INSERT INTO administer_table 
		// 	(administer_name, exam_code, administer_email_address, administer_password, administer_verfication_code,  administer_type, administer_created_on, adminiset_email_verified) 
		// 	VALUES (:administer_name, :exam_code, :administer_email_address, :administer_password, :administer_verfication_code, :administer_type, :administer_created_on, :adminiset_email_verified)
		// 	";
		// 	$exam->execute_query();
		// 	$output = array('success' => 'New Administer/Examiner Details Added');
		// 	echo json_encode($output);
		// }

		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':administer_id'	=>	$_POST['exam_id']
			);

			$exam->query = "DELETE FROM administer_table 
			WHERE administer_id = :administer_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}
	
	}

	if($_POST['page'] == 'calculesion_result_data')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR exam_code LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR exam_result_publish_datetime LIKE "%'.$_POST["search"]["value"].'%" ';

			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();

			$exam->query = "SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();
			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['online_exam_title']);
				$sub_array[] = $row['exam_code'];
				$sub_array[] = $row['total_question'] . ' Question';
				$sub_array[] = $row['online_exam_datetime'];
				$sub_array[] = $row['exam_result_publish_datetime'];

				$publish_button = '';
				$result_button = '';

				if($exam->Is_exam_is_not_started($row["online_exam_id"]))
				{
					$edit_button = '
					<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['online_exam_id'].'">Edit</button>
					';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['online_exam_id'].'">Delete</button>';

				}
				else
				{					
					$result_button = '<a href="exam_process_result.php?code='.$row['exam_code'].'" class="btn btn-dark btn-sm">Process Result</a>';
				}

				$sub_array[] = $result_button;			

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);

		}
	}

	if ($_POST['page'] == 'calculation_result_datas' && $_POST['action'] == 'fetch') 
	{
		$output = array();
	
		$exam->query("SELECT *, 
		CASE WHEN result_published = 1 THEN 'true' ELSE 'false' END AS result_processed 
		FROM online_exam_table 
		WHERE admin_id = '".$_SESSION["admin_id"]."' 
		AND (
			online_exam_title LIKE '%".$_POST["search"]["value"]."%' 
			OR exam_code LIKE '%".$_POST["search"]["value"]."%'
			OR total_question LIKE '%".$_POST["search"]["value"]."%'
			OR online_exam_datetime LIKE '%".$_POST["search"]["value"]."%'
			OR exam_result_publish_datetime LIKE '%".$_POST["search"]["value"]."%'
		)
		");
	
		if (isset($_POST['order'])) {
			$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$exam->query .= 'ORDER BY online_exam_id DESC ';
		}
	
		if ($_POST['length'] != -1) {
			$exam->query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
	
		$filtered_rows = $exam->total_row();
		$result = $exam->query_result();
	
		$total_rows = $exam->total_row();
		$data = array();
	
		foreach ($result as $row) {
			$sub_array = array();
			$sub_array['online_exam_title'] = html_entity_decode($row['online_exam_title']);
			$sub_array['exam_code'] = $row['exam_code'];
			$sub_array['total_question'] = $row['total_question'] . ' Question';
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

	if ($_POST['page'] == 'change_password')
	{
		if ($_POST['action'] == 'change_password')
		{
			$output = array();
	
			// Ensure session is started
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
	
			$admin_id = $_SESSION['admin_id'];
	
			// Assuming you have an $exam object already configured for database operations
			// First, get the current admin details (though this query isn't used later)
			$exam->query = "SELECT `admin_id`, `admin_password` FROM `admin_table` WHERE `admin_id` = ?";
			$exam->data = array($admin_id); // This should be executed to fetch data if needed
			$exam->execute_query();
	
			// Update the password
			$new_password_hashed = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
	
			$exam->query = "UPDATE `admin_table` SET `admin_password` = :admin_password WHERE `admin_id` = :admin_id";
			$exam->data = array(
				':admin_password' => $new_password_hashed,
				':admin_id' => $admin_id
			);
	
			$exam->execute_query();
	
			// Destroy the session after password change
			session_destroy();
	
			// Send success response
			$output = array(
				'success' => 'Password has been changed'
			);
	
			echo json_encode($output);
		}
	}

}

?>