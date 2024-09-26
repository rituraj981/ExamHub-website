<?php
    // Database connection
    $host = 'localhost';
    $dbname = 'my_online_exam_system';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>