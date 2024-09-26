<?php

//login.php

include('../Admin/Examination.php');

$exam = new Examination;

$exam->user_session_public();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JD-Online Exam System User Registration</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="photos/logo_Home.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Admin/CSS/style.css">
    
</head>
<body>
    <span id="message">
        <?php
            if(isset($_GET['verified']))
            {
                echo '
                <div class="alert alert-success">
                    Your email has been verified, now you can login
                </div>
                ';
            }
        ?>   
    </span>
    <div class="wrapper">
        <div class="title-text">
          <div class="title signup">User Registration</div>
        </div>
        <div class="form-container">
          <div class="form-inner login">
            <span id="message"></span>
            <form class="signup" id="user_register_form" action="" method="POST">
                <div class="field">
                   <input type="text"  name="user_name" id="user_name" placeholder="Student Name" required>
                </div>
                <div class="field">
                   <input type="text" name="enrollment_number" id="enrollment_number" placeholder="Enrollment Number" required>
                </div>
                <div class="field">
                   <input type="text" name="user_exam_code" id="user_exam_code" placeholder="Exam Code" required>
                </div>
                <div class="field">
                   <input type="text" name="user_email_address" id="user_email_address" placeholder="Email Address" required>
                </div>
                <div class="field">
                   <input type="password" name="user_password" id="user_password" placeholder="Password" required>
                </div>
                <!-- <div class="field">
                   <input type="password" name="confirm_user_password" id="confirm_user_password" placeholder="Confirm password" required>
                </div> -->
                <div class="form-group field">
                    <input type="text" name="user_mobile_no" required placeholder="Enter Mobile Number" id="user_mobile_no" class="form-control" /> 
                </div>
                <div class="form-group">
                    <select class="form-control" name="user_gender" id="user_gender" required>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                  </select> 
                </div>               
                <div class="form-group">
                    <!-- <label>Select Profile Image</label> -->
                    <input type="file" class="form-control" name="user_image" id="user_image" required />
                </div>
                <div class="field btn">
                  <div class="btn-layer"></div>
                      <input type="hidden" name='page' value='register' />
                      <input type="hidden" name="action" value="register" />
                      <input type="submit" name="user_register" id="user_register"value="register">
                  </div>
                  <div class="field btn">
                      <a href="User_Login-page.php" class="">Login</a>
                  </div>
            </form>
          </div>
        </div>
      </div>
      <script>

$(document).ready(function(){
  window.ParsleyValidator.addValidator('checkemail', {
    validateString: function(value){
      return $.ajax({
        url:'user_ajax_action.php',
        method:'post',
        data:{page:'register', action:'check_email', email:value},
        dataType:"json",
        async: false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });

  $('#user_register_form').parsley();

  $('#user_register_form').on('submit', function(event){
    event.preventDefault();

    $('#user_email_address').attr('required', 'required');

    $('#user_email_address').attr('data-parsley-type', 'email');

    $('#user_password').attr('required', 'required');

    $('#user_password').attr('data-parsley-equalto', '#user_password');

    $('#user_name').attr('required', 'required');

    $('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

    $('#enrollment_number').attr('required', 'required');

    $('#user_exam_code').attr('required', 'required');

    $('#user_mobile_no').attr('required', 'required');

    $('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');

    $('#user_image').attr('required', 'required');

    $('#user_image').attr('accept', 'image/*');

    if($('#user_register_form').parsley().validate())
    {
      $.ajax({
        url:'user_ajax_action.php',
        method:"POST",
        data:new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function()
        {
          $('#user_register').attr('disabled', 'disabled');
          $('#user_register').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#user_register_form')[0].reset();
            $('#user_register_form').parsley().reset();
          }

          $('#user_register').attr('disabled', false);

          $('#user_register').val('Register');
        }
      })
    }

  });
	
});

</script>
    <script src="style\script.js"></script>
</body>
</html>
