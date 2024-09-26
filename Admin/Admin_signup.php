<?php

//login.php

include('Examination.php');

$exam = new Examination;

$exam->admin_session_public();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JD-Online Exam System Admin login</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="..\My_Online_Exam_System\photos\logo_Home.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="CSS/style.css">
    
</head>
<body>
    <span id="messages"></span>
    <div class="wrapper">
        <div class="title-text">
          <div class="title login">Admin Login</div>
          <div class="title signup">Registration</div>
        </div>
        <div class="form-container">
          <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
          </div>
          <div class="form-inner login">
            
            
            <form class="signup" id="admin_register_form" action="" method="POST">
                <div class="field">
                   <input type="text"  name="admin_name" id="admin_name" placeholder="Admin Name" required>
                </div>
                <!-- <div class="field">
                   <input type="text" name="enrollment_number" id="enrollment_number" placeholder="Enrollment Number" required>
                </div> -->
                <div class="field">
                   <input type="text" name="admin_email_address" id="admin_email_address" placeholder="Email Address" required>
                </div>
                <div class="field">
                   <input type="password" name="admin_password" id="admin_password" placeholder="Password" required>
                </div>
                <div class="field">
                   <input type="password" name="confirm_admin_password" id="confirm_admin_password" placeholder="Confirm password" required>
                </div>
                <div class="field btn">
                <div class="btn-layer"></div>
                    <input type="hidden" name='page' value='register' />
                    <input type="hidden" name="action" value="register" />
                    <input type="submit" name="admin_register" id="admin_register"value="register">
              </div>
              <div class="field btn">
                <div class="btn-layer" style="background: green">
                    <input type="button" onclick="window.location.href='Admin_Login-page.php'" value="Login">
                </div>
            </div>


            </form>
            <script>
                $(document).ready(function(){

                    window.ParsleyValidator.addValidator('checkemail', {
                    validateString: function(value)
                    {
                    return $.ajax({
                        url:"ajax_action.php",
                        method:"POST",
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

                $('#admin_register_form').parsley();

                $('#admin_register_form').on('submit', function(event){

                    event.preventDefault();

                    $('#admin_name').attr('required', 'required');

                    $('#admin_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

                    $('#admin_email_address').attr('required', 'required');

                    $('#admin_email_address').attr('data-parsley-type', 'email');

                    $('#admin_password').attr('required', 'required');

                    $('#confirm_admin_password').attr('required', 'required');

                    $('#confirm_admin_password').attr('data-parsley-equalto', '#admin_password');

                    if($('#admin_register_form').parsley().isValid())
                    {
                    $.ajax({
                        url:"ajax_action.php",
                        method:"POST",
                        data:$(this).serialize(),
                        dataType:"json",
                        beforeSend:function(){
                        $('#admin_register').attr('disabled', 'disabled');
                        $('#admin_register').val('please wait...');
                        },
                        success:function(data)
                        {
                        if(data.success)
                        {
                            $('#messages').html('<div class="alert alert-success">Please check your email</div>');
                            $('#admin_register_form')[0].reset();
                            $('#admin_register_form').parsley().reset();
                        }

                        $('#admin_register').attr('disabled', false);
                        $('#admin_register').val('Register');
                        }
                    });
                    }

                });

                });

            </script>
          </div>
        </div>
      </div>
    <!-- <script src="js\script.js"></script> -->
</body>
</html>
