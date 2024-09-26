<?php
  if(isset($_SESSION['user_id']))
  {
?>

<!DOCTYPE html>
<head>
<title>BharatExamHub.com</title>
    <link rel="icon" type="image/png" href="../photos/logo_Home.png">
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <link href="CSS\style.css" rel="stylesheet"/>
    <link href="CSS\index.css" rel="stylesheet"/>

</head>
<body>
      <header class="logo-header">
            <span class="clientlogo"><img src="" class="client" alt="Welcome To BharatExamHub.com"></span>
            <a class="navbar-brand home">
                <img src="Images\logo_Home.png" alt="Logo" class="img-responsive" style="width: 50px">
            </a>
            <a href="javascript:void(0);" class="fulscrnbtn" id="fullScreenA" onclick="toggleFullScreen()">View Full Screen</a>
        </header>
        <script>
        function toggleFullScreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
    </script>
            <div class="container-fluid" style="margin-top: 100px" >
  <?php
  }
  