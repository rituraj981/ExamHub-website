
<?php
// enroll_exam.php

include('../Admin/Examination.php');

$exam = new Examination;
$exam->user_session_private();
$exam->Change_exam_status($_SESSION['user_id']);

include('header.php');

$user_id = $_SESSION['user_id'];

// Fetch the exam details based on the exam code of the logged-in user
$query = "SELECT oe.online_exam_id, oe.admin_id, oe.online_exam_title, oe.exam_code, oe.online_exam_datetime, oe.online_exam_duration, oe.total_question, oe.marks_per_right_answer, oe.marks_per_wrong_answer, oe.question_type, oe.online_exam_created_on, oe.online_exam_status 
          FROM online_exam_table oe 
          INNER JOIN user_table ut ON oe.exam_code = ut.user_exam_code 
          WHERE ut.user_id = :user_id
          ORDER BY oe.online_exam_title ASC";
$statement = $exam->connect->prepare($query);
$statement->execute(['user_id' => $user_id]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($row) {
?>
		<div class="col-md-12" style="width: 50%;margin: auto;">
            <div class="card">
                <div class="card-header">
                    Exam Details
                    <div class="card-header" style="float: right; background: #70c940; font-size: 17px; border-radius: 5px;" id="lefttimer">Left Time: 00:00:00</div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <tr>
                            <td><b>Exam Title</b></td>
                            <td><?php echo $row["online_exam_title"]; ?></td>
                        </tr>
                        <tr>
                            <td><b>Exam Date & Time</b></td>
                            <td><?php echo $row["online_exam_datetime"]; ?></td>
                        </tr>
                        <tr>
                            <td><b>Exam Duration</b></td>
                            <td><?php echo $row["online_exam_duration"]; ?> Minute</td>
                        </tr>
                        <tr>
                            <td><b>Exam Total Question</b></td>
                            <td><?php echo $row["total_question"]; ?> Question</td>
                        </tr>
                        <tr>
                            <td><b>Marks Per Right Answer</b></td>
                            <td><?php echo $row["marks_per_right_answer"]; ?> Mark</td>
                        </tr>
                        <tr>
                            <td><b>Marks Per Wrong Answer</b></td>
                            <td>-<?php echo $row["marks_per_wrong_answer"]; ?> Mark</td>
                        </tr>
                        <tr>
                            <td><b>Exam Type</b></td>
                            <td><?php echo $row["question_type"]; ?></td>
                        </tr>
                    </table>

                    <div id="exam_button_container">
                    <?php
                        // Assuming you have already fetched $row and $user_id correctly
                        $query = "SELECT * FROM `user_exam_enroll_table` WHERE `exam_id` = :exam_id AND `user_id` = :user_id";
                        $statement = $exam->connect->prepare($query);
                        $statement->execute(['exam_id' => $row['online_exam_id'], 'user_id' => $user_id]);

                        if ($statement->rowCount() > 0) {
                            echo '<div style="text-align: center;">';
                            echo '<button type="button" id="start_button" class="btn btn-success" data-exam_id="' . $row['online_exam_id'] . '">Start Exam</button>';
                            echo '</div>';
                        } else {
                            echo '<div style="text-align: center;">';
                            echo '<button type="button" id="enroll_button" class="btn btn-warning" data-exam_id="' . $row['online_exam_id'] . '">Enroll in Exam</button>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>

<script>
$(document).ready(function() {

    var examDateTime = new Date("<?php echo $row['online_exam_datetime']; ?>").getTime();

    // Update the count down every 1 second
    var countdown = setInterval(function() {
        var now = new Date().getTime();
        var distance = examDateTime - now;

        // Time calculations for hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="lefttimer"
        document.getElementById("lefttimer").innerHTML = "Left Time: " + 
            (hours < 10 ? "0" + hours : hours) + "." + 
            (minutes < 10 ? "0" + minutes : minutes) + "." + 
            (seconds < 10 ? "0" + seconds : seconds);

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(countdown);
            document.getElementById("lefttimer").innerHTML = "EXPIRED";
            // Automatically enable the "Start Exam" button
            $('#start_button').prop('disabled', false);
			window.location.href = "student_exam_panel.php?exam_id=" + <?php echo $row['online_exam_id']; ?>;
        }
    }, 1000);


    $(document).on('click', '#enroll_button', function() {
        var exam_id = $(this).data('exam_id');
        $.ajax({
            url: "user_ajax_action.php",
            method: "POST",
            data: { action: 'enroll_exam', exam_id: exam_id },
            beforeSend: function() {
                $('#enroll_button').attr('disabled', 'disabled');
                $('#enroll_button').text('Please wait...');
            },
            success: function(data) {
                $('#enroll_button').attr('disabled', false);
                $('#enroll_button').removeClass('btn-warning');
                $('#enroll_button').addClass('btn-success');
                $('#enroll_button').text('Enroll success');
                $('#enroll_button').attr('id', 'start_button').text('Start Exam');
            }
        });
    });

    $(document).on('click', '#start_button', function() {
        var exam_id = $(this).data('exam_id');
        // window.location.href = "student_exam_panel.php?exam_id=" + exam_id;
    });
});
</script>

<?php
} else {
    echo '<div class="alert alert-danger">No exam found for the provided exam code.</div>';
}
?>
<!-- ->
