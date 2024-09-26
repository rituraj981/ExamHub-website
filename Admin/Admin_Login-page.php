<?php

//login.php

include('Examination.php');

$exam = new Examination;

$exam->admin_session_public();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>BharatExamHub.com</title>
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
          <div class="title login">Admin Login</div>
          <div class="title signup">Registration</div>
        </div>
        <div class="form-container">
          <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <!-- <label for="signup" class="slide signup">Signup</label> -->
            <label for="signup" class="slide signup" onclick="openAdminSignup()">Signup</label>
            <div class="slider-tab"></div>
          </div>
          <div class="form-inner login">
            <form  class="login" id="admin_login_form" method="post">
                <div class="field">
                    <input type="text" name="admin_email_address" id="admin_email_address" placeholder="Email Address" required>
                </div>
                <div class="field">
                    <input type="password" name="admin_password" id="admin_password" placeholder="Password" required>
                </div>
                <div class="pass-link"><a href="#">Forgot password?</a></div>
                <div class="field btn">
                <div class="btn-layer"></div>
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login" />
                    <input type="submit"  name="admin_login" id="admin_login" value="Login">
                </div>
                <div class="signup-link">Not a member? <a href="Admin_signup.php">Register now</a></div>
                <br>
                <div class="social-login">
                  <button class="google-btn" onclick="loginWithGoogle()">Google</button>
                  <button class="facebook-btn" onclick="loginWithFacebook()">Facebook</button>
                  <button class="twitter-btn" onclick="loginWithTwitter()">Twitter</button>
              </div>
            </form>
            <script>
                $(document).ready(function(){

                    $('#admin_login_form').parsley();

                    $('#admin_login_form').on('submit', function(event){
                    event.preventDefault();

                    $('#admin_email_address').attr('required', 'required');

                    $('#admin_email_address').attr('data-parsley-type', 'email');

                    $('#admin_password').attr('required', 'required');

                    if($('#admin_login_form').parsley().validate())
                    {
                        $.ajax({
                        url:"ajax_action.php",
                        method:"POST",
                        data:$(this).serialize(),
                        dataType:"json",
                        beforeSend:function(){
                            $('#admin_login').attr('disabled', 'disabled');
                            $('#admin_login').val('please wait...');
                        },
                        success:function(data)
                        {
                            if(data.success)
                            {
                                // location.href="index.php";
                                location.href = data.redirect_url;
                            }
                            else
                            {
                                $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                            }
                                $('#admin_login').attr('disabled', false);
                                $('#admin_login').val('Login');
                        }
                    });
                }
            });
         });
    </script>
           
          </div>
        </div>
      </div>
    <script>
        function openAdminSignup() {
        // Redirect to admin_signup.php
        window.location.href = 'Admin_signup.php';
        }
   
    </script>
    <!-- <script src="js\script.js"></script> -->
</body>
</html>
