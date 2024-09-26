<?php

//logout.php

session_start();

session_destroy();

header('location:Admin_Login-page.php');

?>