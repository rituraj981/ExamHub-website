<?php

//logout.php

session_start();

session_destroy();

header('location:User_Login-page.php');

?>