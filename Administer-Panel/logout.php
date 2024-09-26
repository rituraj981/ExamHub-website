<?php

//logout.php

session_start();

session_destroy();

header('location: ../Admin/Admin_Login-page.php');

?>