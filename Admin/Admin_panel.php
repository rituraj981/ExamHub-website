<?php

session_start();

include '../mainfile.php';

if(!isset($_SESSION['admin_id']))
{
  header("location: Admin_Login-page.php");
}

?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <script src="js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script> 

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <script src="../style/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="../style/bootstrap-datetimepicker.css" />
    <title>BharatExamHub Admin Panel</title>
    <link rel="icon" type="image/png" href="image\\logo_Home.png">
    <link href="CSS\sidebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS\admin_panel.css">

  </head>
  <body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="image\\logo_Home.png" alt="logo">
        <span class="d-none d-lg-block">Admin Panel</span>
      </a>
      <img src="image\sideber_in.png" class="toggle-sidebar-btn">

    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <!-- <i class="bi bi-bell"></i> -->
            <img src="image\notifications_icon.png" class="toggle-sidebar-btn">
            <span class="badge bg-primary badge-number">3</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 3 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <img src="image\messages_icon.png" class="toggle-sidebar-btn">
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->
        <?php
            if (session_status() === PHP_SESSION_NONE) {
              session_start();
            }
            
            // Get the admin_id from the session
            $admin_id = $_SESSION['admin_id'];
            
            // Prepare the SQL statement to select the admin details based on the admin_id
            $stmt = $conn->prepare("SELECT `admin_id`, `admin_image`, `admin_name`, `admin_type` FROM `admin_table` WHERE `admin_id` = ?");
            $stmt->bind_param('s', $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Initialize variables
            $admin_name = '';
            $admin_type = '';
            
            // Check if there are any results
            if ($result->num_rows > 0) {
                // Fetch the admin details
                $row = $result->fetch_assoc();
                $admin_type = htmlspecialchars($row["admin_type"], ENT_QUOTES, 'UTF-8');
                $admin_name = htmlspecialchars($row["admin_name"], ENT_QUOTES, 'UTF-8');
                $admin_image = htmlspecialchars($row["admin_image"], ENT_QUOTES, 'UTF-8');
            }
          
          // Close the statement
          $stmt->close();
          if (empty($admin_image) || !file_exists("../upload_image/" . $admin_image)) {
            $admin_image = 'upload_image/default_profile.png';
        } else {
            $admin_image = "Admin/upload_image/" . $admin_image;
        }
        ?>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img class="rounded-circle" src="<?php echo $admin_image; ?>" alt="">
            <!-- <span class="d-none d-md-block dropdown-toggle ps-2">Lokesh saini</span> -->
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $admin_name; ?></h6>
              <span><?php echo $admin_type; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
                <img src="image\profile_icon.png" class="toggle-sidebar-btn">
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <img src="image\reset-password.png" class="toggle-sidebar-btn">
                <span>Change Password</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <img src="image\setting.png" class="toggle-sidebar-btn">
                <span>Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <img src="image\logout.png" class="toggle-sidebar-btn">
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="Home_panel.php">
          <img src="image\home.png" alt="Home" width="25" height="25" class="me-2">
          <span>Home</span>
        </a>
      </li>

      <!-- Start Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="Dashborad_panel.php">
          <img src="image\speedometer.png" alt="Dashboard" width="25" height="25" class="me-2">
          <span>Dashboard</span>
          <!-- <i class="bi bi-chevron-down ms-auto"></i> -->
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <!-- Start Student Panel Nav -->
      <li class="nav-item">
        <a href="#" class="nav-link collapsed" data-bs-target="#tables_stud_list" data-bs-toggle="collapse">
          <img src="image\student.png" alt="Student Panel" width="25" height="25" class="me-2">
          <span>Student Panel</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables_stud_list" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Student_panel.php" aria-expanded="false">
              <img src="image\exam.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Student List</span>
            </a>
          </li>
          <li>
            <a href="Student_enroll_list.php" aria-expanded="false">
              <img src="image\study.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Student Enroll List</span>
            </a>
          </li>
        </ul>
        </li>
      <!-- End Student Panel Nav -->

      <!-- Start Online Examination Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <img src="image\knowledge.png" alt="Online Examination" width="25" height="25" class="me-2">
          <span>Online Examination</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Online_exam_panel.php" aria-expanded="false">
              <img src="image\exam.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Exam Dashboard</span>
            </a>
          </li>
          <li>
            <a href="Online_exam_table.php" aria-expanded="false">
              <img src="image\study.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Exam Tables</span>
            </a>
          </li>
          <li>
            <a href="Online_Section_table.php" aria-expanded="false">
              <img src="image\knowledge.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Section & Question Tables</span>
            </a>
          </li>
        </ul>
        </li>
      <!-- End Online Examination Nav -->

      <!-- Start View Exam Results Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse"  href="#">
          <img src="image\exam-results.png" alt="Online Examination" width="25" height="25" class="me-2">
          <span>View Exam Results</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="Exam_result_panel.php"aria-expanded="false">
              <img src="image\exam.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Results</span>
            </a>
          </li>
          <li>
            <a href="Exam_answerkey.php"aria-expanded="false">
              <img src="image\education.png" alt="Online Examination" width="25" height="25" class="me-2">
              <span>Answer key</span>
            </a>
          </li>
        </ul>
        </li>
      <!-- End View Exam Results Nav -->

      <!-- Start Organisation Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#organisation-nav" data-bs-toggle="collapse" href="">
              <img src="image\collaboration.png" alt="Profile" width="25" height="25" class="me-2">
              <span>Organisation</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
          <ul id="organisation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="admin_profile.php"aria-expanded="false">
                <img src="image/master-admin.png" alt="Profile" width="25" height="25" class="me-2">
                <span>Master Admin Logs</span>
              </a>
            </li>
            <li>
              <a aria-expanded="false" href="organisation_administer_admin_panel.php">
                <img src="image/sub-admin.png" alt="Profile" width="25" height="25" class="me-2">
                <span> Administer logs</span> 
              </a>
            </li>
            <li>
              <a aria-expanded="false" href="organisation_administer_admin_panel.php">
                <img src="image/eye-examiner.png" alt="Profile" width="25" height="25" class="me-2">
                <span>Examiner Logs</span>
              </a>
            </li>
            <li>
              <a href="organisation_profile.php"aria-expanded="false">
                <img src="image\default_profile.png" alt="Profile" width="25" height="25" class="me-2">
                <span>Organisation Profile</span>
              </a>
            </li>
          </ul>
        </li>
      <!-- End Organisation Nav -->

      <!-- Start Profile Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <img src="image\default_profile.png" alt="Profile" width="25" height="25" class="me-2">
          <span>Profile</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="admin_profile.php"aria-expanded="false">
              <img src="image\profile_icon.png" alt="Profile" width="25" height="25" class="me-2">
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <a aria-expanded="false" href="admin_profile.php">
              <img src="image\reset-password.png" alt="Profile" width="25" height="25" class="me-2">
              <span>Change Password</span>
            </a>
          </li>
          <li>
            <a aria-expanded="false" href="admin_profile.php">
              <img src="image\setting.png" alt="Profile" width="25" height="25" class="me-2">
              <span>Settings</span>
            </a>
          </li>
        </ul>
        </li>
      <!-- EndProfile Nav -->

      <!-- Start View Exam Results Nav -->
      <li class="nav-heading">Logout this page
          <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="" href="logout.php">
            <img src="image\logout.png" alt="Profile" width="25" height="25" class="me-2">
            <span>Sign Out</span>
          </a>
        </li>
      <!-- End Icons Nav -->

      <li class="nav-heading">JD Developer</li>
          <a class="nav-link collapsed" href="http://jdsoftdeveloper.kesug.com"  style="text-decoration: none;color: black">Copyright &copy; 2024 by JD Developer | All Rights Reserved</a> 

  </aside>
  <!-- End Sidebar-->


  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- <script src="CSS\editor_css\jquery.dataTables.min.js"></script>
  <script src="CSS\editor_css\jquery.easing.min.js"></script> -->
  <!-- <script src="CSS\editor_css\jquery.min.js"></script> -->

  <script src="js\main.js"></script>
</body>
<html>