<?php
   include '../mainfile.php';

   include('../Admin/Examination.php');

   $exam = new Examination;

   $exam->user_session_private();
// Assume $user_id is set from session
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

        .que-not-attempted {
            background-color: #ff9800;
            color: #fff;
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
    </style>
    <body>
    <body>
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
    <div style="border-top:1px solid #808080;padding-top:10px;" class="col-md-12 exam_btn">
        <button class="full-width btn btn-success btn-save-answer" onclick="loadPreviousQuestion()">&lt;&lt; Back</button>
        <button class="full-width btn btn-success btn-mark-answer" onclick="saveAnswerAndLoadNext()">Save & Next</button>
        <button class="full-width btn btn-warning btn-save-mark-answer" onclick="saveMarkForReview()">Save & Mark For Review</button>
        <button class="full-width btn btn-default btn-reset-answer" onclick="clearResponse()">Clear Response</button>
        <button class="full-width btn btn-primary btn-mark-answer" onclick="markForReviewAndNext()">Mark For Review & Next</button>
        <button class="full-width btn btn-success btn-save-answer" onclick="nextQuestion()">Next &gt;&gt;</button>
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
                } else if (xhr.readyState === 4) {
                    alert('An error occurred while saving the answer. Please try again.');
                }
            };
            xhr.send("question_id=" + encodeURIComponent(questionId) + "&user_id=" + encodeURIComponent(userId) + "&selected_option=" + encodeURIComponent(selectedValue));
        } else {
            alert('Please select an option before proceeding.');
        }
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
            } else if (xhr.readyState === 4) {
                alert('An error occurred while saving the answer. Please try again.');
            }
        };
        xhr.send("question_id=" + encodeURIComponent(questionId) + "&user_id=" + encodeURIComponent(userId) + "&selected_option=" + encodeURIComponent(selectedValue));
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
