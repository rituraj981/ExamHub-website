<?php

//login.php

include('../Admin/Examination.php');

$exam = new Examination;

$exam->user_session_public();

include('header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JD-Online Exam System User login</title>
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
          <div class="title login">Login Form</div>
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
            <form  class="login" action="" id="user_login_form" method="POST">
                <div class="field">
                    <input type="text" name="user_email_address" placeholder="Email Address" required>
                </div>
                <div class="field">
                    <input type="password" name="user_password" placeholder="Password" required>
                </div>
                <div class="pass-link">
                    <a href="#">Forgot password?</a>
                </div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                        <input type="hidden" name="page" value="login" />
                        <input type="hidden" name="action" value="login" />
                        <input type="submit"  name="user_login" id="user_login" value="Login">
                    </div>
                <div class="signup-link">Not a member? 
                    <a href="Registrantion_page.php">Register now</a></div>
                <br><br>
                <!-- <div class="social-login">
                  <button class="facebook-btn" onclick="loginWithGoogle()">Google</button>
                  <button class="google-btn" onclick="loginWithFacebook()">Facebook</button>
                  <button class="twitter-btn" onclick="loginWithTwitter()">Twitter</button>
              </div> -->
            </form>
        </div>
            <script>
                $(document).ready(function(){

                    $('#user_login_form').parsley();
                    $('#user_login_form').on('submit', function(event){
                    event.preventDefault();
                    $('#user_email_address').attr('required', 'required');
                    $('#user_email_address').attr('data-parsley-type', 'email');
                    $('#user_password').attr('required', 'required');
                    if($('#user_login_form').parsley().validate())
                    {
                        $.ajax({
                        url:"user_ajax_action.php",
                        method:"POST",
                        data:$(this).serialize(),
                        dataType:"json",
                        beforeSend:function()
                        {
                            $('#user_login').attr('disabled', 'disabled');
                            $('#user_login').val('please wait...');
                        },
                        success:function(data)
                        {
                            if(data.success)
                            {
                            location.href='index.php';
                            }
                            else
                            {
                            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                            }

                            $('#user_login').attr('disabled', false);

                            $('#user_login').val('Login');
                        }
                        })
                    }

                    });
                });
            </script>
          
    <script src="style\script.js"></script>
</body>
</html>
