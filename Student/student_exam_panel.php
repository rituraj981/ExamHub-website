<?php
    //view_exam.php

    include '../mainfile.php';

    include('../Admin/Examination.php');

    $exam = new Examination;

    $exam->user_session_private();

    if (!isset($_SESSION['user_id'])) {
        // Handle the case where the user ID is not set
        echo "User ID is not set. Please log in again.";
        exit;
    }
    
    $user_id = $_SESSION['user_id'];

?>

<?php
    $stmt = $conn->prepare("SELECT user_image, user_name, enrollment_number FROM user_table WHERE user_id = ?");
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_image = htmlspecialchars($row["user_image"], ENT_QUOTES, 'UTF-8');
            $user_name = htmlspecialchars($row["user_name"], ENT_QUOTES, 'UTF-8');
            $enrollment_number = htmlspecialchars($row["enrollment_number"], ENT_QUOTES, 'UTF-8');
                                
        } 
    }   
    $stmt->close();
?>

<?php
     // Fetch the exam_code for the logged-in user
    $stmt = $conn->prepare("SELECT `user_exam_code` FROM `user_table` WHERE `user_id` = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_details = $stmt->get_result()->fetch_assoc();

     if (!$user_details) {
        // Handle the case where no user details are found
        echo "No user details found. Please contact support.";
        exit;
    }

    $exam_code = $user_details['user_exam_code'];
    $stmt->close();

    // Fetch exam details from online_exam_table where exam_code matches
    $stmt = $conn->prepare("SELECT `online_exam_id`, `online_exam_title`, `exam_code`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `question_type` FROM `online_exam_table` WHERE `exam_code` = ?");
    $stmt->bind_param("s", $exam_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $online_exam_title = htmlspecialchars($row["online_exam_title"], ENT_QUOTES, 'UTF-8');
            // $marks_per_right_answer = htmlspecialchars($row["marks_per_right_answer"], ENT_QUOTES, 'UTF-8');
            // $marks_per_wrong_answer = htmlspecialchars($row["marks_per_wrong_answer"], ENT_QUOTES, 'UTF-8');
            $exam_time_minutes = htmlspecialchars($row["online_exam_duration"], ENT_QUOTES, 'UTF-8');
            $question_type = htmlspecialchars($row["question_type"], ENT_QUOTES, 'UTF-8');
            // You can add more fields if needed
         }
    } else {
        echo "No exams found for the provided exam code.";
        exit;
     }
    $stmt->close();
?>
<?php
    $user_id = $_SESSION['user_id']; 

    // Fetch user details
    $stmt = $conn->prepare("SELECT `user_id`, `user_exam_code` FROM `user_table` WHERE `user_id` = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_details = $stmt->get_result()->fetch_assoc();
    $exam_code = $user_details['user_exam_code'];
    
    // Fetch questions for the user's exam
    $stmt = $conn->prepare("SELECT `question_id`, `admin_id`, `exam_code`, `section_name`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `exam_subject_question_title`, `option_title_1`, `option_title_2`, `option_title_3`, `option_title_4`, `exam_subject_question_answer` FROM `all_subject_question_paper` WHERE `exam_code` = ?");
    $stmt->bind_param("s", $exam_code);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $questions = array();
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
    
    $questions_json = json_encode($questions);

?>
    
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>BharatExamHub.com</title>
    <link rel="icon" type="image/png" href="../photos/logo_Home.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="CSS\style.css" rel="stylesheet"/>
    </head>
    <style>
        #countdown-timer {
            color: black;
        }
        .green {
            background: green;
            font-weight: bold;
        }
        .red {
            background: red;
            font-weight: bold;
        }
        .test-ques {
            padding: 5px 10px;
            margin: 2px;
            display: inline-block;
            text-align: center;
            border-radius: 50%;
            margin: 5px;
            font-size: 17px
            
        }
        .que-not-answered {
            background-color: #65c5d5;
            color: #000;
        }

        .que-active {
            background-color: #2196f3;
            color: #fff;
        }
        .que-current {
            border: 2px solid #ff5722;
        }
        .que-marked-review {
            background-color: rgb(107, 32, 168);
            color: #fff;
        }
        .que-marked-next {
            background-color: rgb(201, 189, 18);
            color: #fff;
        }
        .que-next {
            background-color: red;
            color: #fff;
        }

        .que-marked-review-answered {
            background-color: orange;
            color: black;
        }

        .que-answered {
            background-color: green; 
            color: white;
        }
        #options {
            width: 20px;
        }
    </style>
    <body>
    <body>
        <header class="logo-header">
            <span class="clientlogo">Welcome To JD Online Exam.com</span>
            <a class="navbar-brand home">
                <img src="Images\logo_Home.png" alt="Logo" class="img-responsive"  style="width: 50px">
            </a>
            <a href="javascript:void(0);" class="fulscrnbtn" id="fullScreenA" onclick="toggleFullScreen()">View Full Screen</a>
        </header>
        <!-- this tap are used for bottom -->

        <div class="top-head" style="margin-top: 60px">
            <div class="bottom-legend">
                <div class="left-data">Exam Name : <?php echo $online_exam_title; ?>
                    <div class="data-right">
                        <table>
                        <tbody>
                            <tr>
                                <td><a onclick="allquestion()" style="line-height: 21px;" id="ques"><span class="questionpaper_icon"></span>Question paper</a></td>
                                <td><a onclick="showInstruction();" style="line-height: 21px;"><span class="instruction_icon"> </span>Instruction </a></td>
                            </tr>   
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="exam_left_side">
                    <div class="heading-breadcrumbs">
                        <?php
                            // Fetch unique section names
                            $section_names = array_unique(array_column($questions, 'section_name'));
                                foreach ($section_names as $section_name) {
                                    echo '<div class="sbjctbtn-prt">
                                            <div class="btnsbjct-box">
                                                <button type="button" class="btncls" onclick="showQuestions(\'' . $section_name . '\')">' . $section_name . '</button>
                                            </div>
                                        </div>';
                                }
                        ?>
                    </div>
                    <div class="maxi-neg-number">
                        <div style="text-transform:capitalize; font-weight:bold; border-radius:6px; font-size:17px;">
                            Maximum Mark: <span style="color:#4d914d; font-weight:bold;" id="spanRightMarks"></span>&nbsp;&nbsp;
                            <div style="color:#d4d4d4; font-size:10px; border-left:1px #d4d4d4 solid; float: right;"></div>&nbsp;&nbsp;
                            Negative Mark: <span style="color:#d90d0d; font-weight:bold;" id="spanWrongMarks"></span>
                        </div>
                    </div>
                </div>
            <div class="exam_right_side">  
                <div class="student" id="student">
                    <div class="navbar-header">
                        <a class="navbar-brand home">
                            <img class="user-image" src="../Student/upload/<?php echo $user_image; ?>" alt="User image">
                        </a>         
                    </div>
                    <div class="profiledetail">
                        <div class="name_sctn">
                            <span class="txt_namehdng">Candidate Name</span>
                            <span class="name_txt">: <?php echo $user_name; ?>
                        </div>
                        <div class="name_sctn">
                            <span class="txt_namehdng">Candidate ID</span>
                            <span class="name_txt">: <?php echo $enrollment_number; ?></span>
                        </div>
                        <div class="name_sctn">
                            <span class="txt_namehdng">Left Time</span>
                            <span class="name_txt">: <span class="timer-title time-started" id="countdown-timer">00.00.00</span></span>
                        </div>
                        <script>
                            function left_time() {
                                var countdownElement = document.getElementById('countdown-timer');
                                var examTimeInSeconds = <?php echo $exam_time_minutes * 60; ?>; // Convert minutes to seconds

                                function updateTimer() {
                                    var hours = Math.floor(examTimeInSeconds / 3600);
                                    var minutes = Math.floor((examTimeInSeconds % 3600) / 60);
                                    var seconds = examTimeInSeconds % 60;

                                    // Format the time to display in HH:MM:SS format
                                    var timeString = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                                    countdownElement.innerHTML = timeString;

                                    // Change color based on specific conditions
                                    if (examTimeInSeconds <= 120) { // 2 minutes = 120 seconds
                                        countdownElement.classList.add('red');
                                        countdownElement.classList.remove('green');
                                    } else if (examTimeInSeconds <= 300) { // 5 minutes = 300 seconds
                                        countdownElement.classList.add('green');
                                        countdownElement.classList.remove('red');
                                    } else {
                                        countdownElement.classList.remove('green', 'red');
                                    }

                                    // If time is up
                                    if (examTimeInSeconds <= 0) {
                                        clearInterval(timer);
                                        alert("Time's up!");
                                        window.location.href = 'exam_submit_data.php';
                                    } else {
                                        examTimeInSeconds--;
                                    }
                                }

                                updateTimer(); // Initial call to display timer immediately
                                var timer = setInterval(updateTimer, 1000); // Update timer every second
                            }

                            window.onload = function() {
                                loadQuestion(currentQuestionIndex);
                                updateNavigation();
                                left_time(); // Start the timer automatically when the page loads
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <!-- this code are used for container 2  -->
        <div class="container2">
            <div class="question_left_side">
                <div class="questiontype_language">
                    <div class="left-sec-p-new">
                        <h3>Question Type:  <?php echo $question_type; ?></h3>
                    </div>
                    <div class="slctlnguage_box">
                        <select class="selectbox-language">
                            <option>English</option>
                            <option>Hindi</option>
                        </select>
                    </div>
                </div>

                <!-- this html code are question paper  -->
                <div class="question-height">
                     <div id="load_question" class="hdngsctn-qst">
                        <div id="question-title" style="margin: 20px 0; font-size: 21px;"></div>
                            <div class="anwrsoptn-qst">
                                <table class="table table-borderless mb0" style="font-size: 20px;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" value="1" name="options" id="option1"> A.
                                                <label for="option1" id="option1-label"></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="2" name="options" id="option2"> B.
                                                <label for="option2" id="option2-label"></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="3" name="options" id="option3"> C.
                                                <label for="option3" id="option3-label"></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="4" name="options" id="option4"> D.
                                                <label for="option4" id="option4-label"></label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div style="border-top:1px solid #4c5e9b;padding:10px;" class="col-md-12 exam_btn">
                        <button class="full-width btn btn-success btn-save-answer" onclick="loadPreviousQuestion()">&lt;&lt; Back</button>
                        <button class="full-width btn btn-success btn-mark-answer"  onclick="saveAnswerAndLoadNext()">Save & Next</button>
                        <button class="full-width btn btn-warning btn-save-mark-answer" onclick="saveMarkForReview()">Save & Mark For Review</button>
                        <button class="full-width btn btn-default btn-reset-answer" onclick="clearResponse()">Clear Response</button>
                        <button class="full-width btn btn-primary btn-mark-answer" onclick="markForReviewAndNext()">Mark For Review & Next</button>
                        <button class="full-width btn btn-success btn-save-answer" onclick="nextQuestion()">Next &gt;&gt;</button>
                    </div>
                </div>
            <div class="question_right_side">
                <div class="panel-body">
                    <table class="table table-borderless mb0 mark_wapper">
                        <tbody>
                            <tr>
                                <td class="full-width">
                                    <a class="test-ques-stats que-not-attempted lblNotVisited">0</a>
                                    Not Visited 
                                </td>
                                <td class="full-width">
                                    <a class="test-ques-stats que-not-answered lblNotAttempted">0</a>
                                    Not Answered 
                                </td>
                            </tr>
                            <tr>
                                <td class="full-width">
                                    <a class="test-ques-stats que-save lblTotalSaved">0</a>
                                    Answered 
                                </td>
                                <td class="full-width">
                                    <a class="test-ques-stats que-mark lblTotalMarkForReview">0</a>
                                    Marked for Review 
                                </td>
                            </tr>
                            <tr>
                                <td class="full-width">
                                    <a class="test-ques-stats que-save-mark lblTotalSaveMarkForReview">0</a>
                                     Answered &amp; Marked for Review (will be considered for evaluation) 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-default ">
                    <div class="hdngpalt" id="question_pallete_ssc">Questions</div>
                        <div class="panel-body " style="height:45vh; overflow-y:scroll;">
                            <div class="question-choose">Choose a Question</div>
                            <ul class="tstpage-pagination test-questions">
                            </ul>
                        </div>
                </div>
                <div  class="col-md-12 exam_btn" style="padding-top:10px; float: right; margin-right: 20px">
                    <button class="full-width btn btn-success btn-save-answer" onclick="openProfile()">Profile</button>
                    <button class="full-width btn btn-warning btn-save-mark-answer" onclick="showConfirmationDialog()">Submit</button>
                </div>
                <div id="confirmationDialog" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="hideConfirmationDialog()">&times;</span>
                        <div class="image-container">
                            <img src="Images\logo_Home.png" alt="Confirmation">
                        </div>
                        <p>Are you sure?</p>
                        <p>You want to submit your answers?</p>
                        <div class="buttons">
                            <button class="ok-button" onclick="handleOkClick()">OK</button>
                            <button class="cancel-button" onclick="hideConfirmationDialog()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var userId = <?php echo json_encode($user_id); ?>;
            var questions = <?php echo $questions_json; ?>;
            var currentQuestionIndex = 0;
            var userAnswers = [];
            var markedForReview = [];
            
            // Initialize userAnswers array with null values
            for (var i = 0; i < questions.length; i++) {
                userAnswers.push(null);
                markedForReview.push(false);
            }

            function loadQuestion(index) {
                if (index < 0 || index >= questions.length) {
                    return;
                }
                currentQuestionIndex = index;

                var question = questions[index];
                document.getElementById('question-title').innerHTML = (index + 1) + '. ' + question.exam_subject_question_title;
                document.getElementById('option1-label').innerHTML = question.option_title_1;
                document.getElementById('option2-label').innerHTML = question.option_title_2;
                document.getElementById('option3-label').innerHTML = question.option_title_3;
                document.getElementById('option4-label').innerHTML = question.option_title_4;
                document.getElementById('spanRightMarks').innerText = question.marks_per_right_answer;
                document.getElementById('spanWrongMarks').innerText = question.marks_per_wrong_answer;

                document.getElementById('option1').checked = false;
                document.getElementById('option2').checked = false;
                document.getElementById('option3').checked = false;
                document.getElementById('option4').checked = false;

                if (userAnswers[index] !== null) {
                    document.getElementById('option' + userAnswers[index]).checked = true;
                }

                updateNavigation();
            }

            function saveAnswerAndLoadNext() {
                var selectedOption = document.querySelector('input[name="options"]:checked');
                if (selectedOption) {
                    var selectedValue = selectedOption.value;
                    userAnswers[currentQuestionIndex] = selectedValue;

                    var questionId = questions[currentQuestionIndex].question_id;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "save_optioncopy.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                if (currentQuestionIndex < questions.length - 1) {
                                    currentQuestionIndex++;
                                    loadQuestion(currentQuestionIndex);
                                } else {
                                    alert('You have completed the exam.');
                                }
                            } else {
                                alert('Error saving answer: ' + response.message);
                            }
                        }
                    };
                    xhr.send("question_id=" + questionId + "&user_id=" + userId + "&selected_option=" + selectedValue);
                } else {
                    alert('Please select an option before proceeding.');
                }
            }

            function loadPreviousQuestion() {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    loadQuestion(currentQuestionIndex);
                }
            }

            function saveMarkForReview() {
                var selectedOption = document.querySelector('input[name="options"]:checked');
                if (selectedOption) {
                    var selectedValue = selectedOption.value;
                    userAnswers[currentQuestionIndex] = selectedValue;

                    var questionId = questions[currentQuestionIndex].question_id;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "save_optioncopy.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                markedForReview[currentQuestionIndex] = true;
                                updateNavigation();
                                if (currentQuestionIndex < questions.length - 1) {
                                    currentQuestionIndex++;
                                    loadQuestion(currentQuestionIndex);
                                } else {
                                    alert('You have completed the exam.');
                                }
                            } else {
                                alert('Error saving answer: ' + response.message);
                            }
                        }
                    };
                    xhr.send("question_id=" + questionId + "&user_id=" + userId + "&selected_option=" + selectedValue);
                } else {
                    alert('Please select an option before proceeding.');
                }
            }

            function clearResponse() {
                userAnswers[currentQuestionIndex] = null;
                markedForReview[currentQuestionIndex] = false;
                var selectedOption = document.querySelector('input[name="options"]:checked');
                if (selectedOption) {
                    selectedOption.checked = false;
                }
                updateNavigation();
            }

            function markForReviewAndNext() {
                markedForReview[currentQuestionIndex] = true;
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    loadQuestion(currentQuestionIndex);
                }
                updateNavigation();
            }

            function nextQuestion() {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    loadQuestion(currentQuestionIndex);
                }
                updateNavigation();
            }

            function updateNavigation() {
                var navigation = document.querySelector('.test-questions');
                navigation.innerHTML = '';

                for (var i = 0; i < questions.length; i++) {
                    var li = document.createElement('li');
                    var a = document.createElement('a');
                    a.classList.add('test-ques');

                    if (i === currentQuestionIndex) {
                        a.classList.add('que-current');
                    } else if (markedForReview[i] && userAnswers[i] !== null) {
                        a.classList.add('que-marked-review-answered'); // This will be the yellow color
                    } else if (markedForReview[i]) {
                        a.classList.add('que-marked-review'); // This will be the default marked for review color
                    } else if (userAnswers[i] !== null) {
                        a.classList.add('que-answered');
                    } else {
                        a.classList.add('que-not-answered');
                    }

                    a.innerHTML = (i + 1).toString();
                    a.href = 'javascript:void(0);';
                    a.onclick = (function(index) {
                        return function() {
                            loadQuestion(index);
                        };
                    })(i);
                    li.appendChild(a);
                    navigation.appendChild(li);
                }

                // Update question statistics
                var notVisitedCount = questions.length - userAnswers.filter(answer => answer !== null).length - markedForReview.filter(Boolean).length;
                var notAttemptedCount = userAnswers.filter((answer, index) => answer === null && !markedForReview[index]).length;
                var totalSavedCount = userAnswers.filter(answer => answer !== null).length;
                var totalMarkedForReviewCount = markedForReview.filter(Boolean).length;
                var totalSaveMarkForReviewCount = userAnswers.filter((answer, index) => answer !== null && markedForReview[index]).length;

                document.querySelector('.lblNotVisited').innerHTML = notVisitedCount;
                document.querySelector('.lblNotAttempted').innerHTML = notAttemptedCount;
                document.querySelector('.lblTotalSaved').innerHTML = totalSavedCount;
                document.querySelector('.lblTotalMarkForReview').innerHTML = totalMarkedForReviewCount;
                document.querySelector('.lblTotalSaveMarkForReview').innerHTML = totalSaveMarkForReviewCount;
            }

            function showConfirmationDialog() {
                document.getElementById('confirmationDialog').style.display = 'block';
            }

            function hideConfirmationDialog() {
                document.getElementById('confirmationDialog').style.display = 'none';
            }

            function submitAnswers() {
                console.log('Submitting answers:', userAnswers);
                window.location.href = 'exam_submit_data.php';
            }

            function handleOkClick() {
                hideConfirmationDialog();
                submitAnswers();
            }

            function openProfile() {
                // Implement the logic to open the profile section here
                alert('Profile section opened!');
            }

            window.onload = function() {
                loadQuestion(currentQuestionIndex);
                updateNavigation();
            }
            function toggleFullScreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
            
        </script>
    </body>
</html>
