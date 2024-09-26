<?php 

session_start();

include '../mainfile.php';

if(!isset($_SESSION['administer_id']))
{
  header("location:../Admin/Admin_Login-page.php");
}

  $admin_id = $_SESSION['administer_id'];
  $query = "SELECT administer_email_address, administer_type FROM administer_table WHERE administer_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $admin_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $admin_details = $result->fetch_assoc();

  // Fetch notifications for the logged-in sub-admin
  $notifications_query = "
      SELECT n.admin_id, n.notification_msg, n.created_at, a.admin_name
      FROM administer_notification_table n
      JOIN admin_table a ON n.admin_id = a.admin_id
      WHERE n.administer_id = ?
      ORDER BY n.created_at DESC
  ";
  $notifications_stmt = $conn->prepare($notifications_query);
  $notifications_stmt->bind_param('i', $admin_id);
  $notifications_stmt->execute();
  $notifications_result = $notifications_stmt->get_result();
  $notifications = $notifications_result->fetch_all(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <script src="../Admin/js/color-modes.js"></script>
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

    <link href="../Admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../Admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <script src="../style/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="../style/bootstrap-datetimepicker.css" />
    <title>BharatExamHub Administer Panel</title>
    <link rel="icon" type="" href="../Admin\image\logo_Home.png">
    <link href="../Admin\CSS\sidebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Admin\CSS\admin_panel.css">

  </head>
  <body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="../Admin/image\\logo_Home.png" alt="logo">
        <span class="d-none d-lg-block">Administer Panel</span>
      </a>
      <img src="../Admin/image\sideber_in.png" class="toggle-sidebar-btn">

    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <img src="../Admin/image/notifications_icon.png" class="toggle-sidebar-btn">
                    <span class="badge bg-primary badge-number"><?php echo count($notifications); ?></span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have <?php echo count($notifications); ?> new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php foreach ($notifications as $notification): ?>
                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4><?php echo htmlspecialchars($notification['admin_name']); ?></h4>
                                <p><?php echo htmlspecialchars($notification['notification_msg']); ?></p>
                                <p><?php echo htmlspecialchars($notification['created_at']); ?></p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    <?php endforeach; ?>
                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>
          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        </li><!-- End Messages Nav -->
        <?php     
            $administer_id = $_SESSION['administer_id'];

            // Prepare and bind
            $stmt = $conn->prepare("SELECT `administer_id`, `administer_name`, `administer_type` FROM `administer_table` WHERE `administer_id` = ?");
            $stmt->bind_param("i", $administer_id);

            $stmt->execute();

            $stmt->bind_result($administer_id, $administer_name, $administer_type);

            $stmt->fetch();

            $stmt->close();
            $conn->close();
          ?>
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../Admin/image/default_profile.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $administer_name; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $administer_name; ?></h6>
              <span><?php echo $administer_type; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="administer_profile.php">
                <img src="../Admin/image\profile_icon.png" class="toggle-sidebar-btn">
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <img src="../Admin/image\reset-password.png" class="toggle-sidebar-btn">
                <span>Change Password</span>
              </a>
            </li> -->
            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <img src="../Admin/image\setting.png" class="toggle-sidebar-btn">
                <span>Settings</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <img src="../Admin/image\logout.png" class="toggle-sidebar-btn">
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
          <img src="../Admin/image\home.png" alt="Home" width="25" height="25" class="me-2">
          <span>Home</span>
        </a>
      </li>

      <!-- Start Dashboard Nav -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="Dashborad_panel.php">
          <img src="../Admin/image\speedometer.png" alt="Dashboard" width="25" height="25" class="me-2">
          <span>Dashboard</span>
        </a>
        </li> -->
      <!-- End Dashboard Nav -->

      <!-- Start Student Panel Nav -->
      <li class="nav-item">
        <a href="administer_student_panel.php" class="nav-link collapsed">
          <img src="../Admin/image\student.png" alt="Student Panel" width="25" height="25" class="me-2">
          <span>Student Panel</span>
        </a>
      </li>
      <!-- End Student Panel Nav -->

      <!-- Start Profile Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <img src="../Admin/image\default_profile.png" alt="Profile" width="25" height="25" class="me-2">
          <span>Profile</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="administer_profile.php"aria-expanded="false">
              <img src="../Admin/image\profile_icon.png" alt="Profile" width="25" height="25" class="me-2">
              <span>My Profile</span>
            </a>
          </li>
          <!-- <li>
            <a aria-expanded="false" href="administer_profile.php">
              <img src="../Admin/image\reset-password.png" alt="Profile" width="25" height="25" class="me-2">
              <span>Change Password</span>
            </a>
          </li> -->
          <!-- <li>
            <a aria-expanded="false" href="administer_profile.php">
              <img src="../Admin/image\setting.png" alt="Profile" width="25" height="25" class="me-2">
              <span>Settings</span>
            </a>
          </li> -->
        </ul>
        </li>
      <!-- EndProfile Nav -->

      <!-- Start View Exam Results Nav -->
      <li class="nav-heading">Logout this page
          <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="" href="logout.php">
            <img src="../Admin/image\logout.png" alt="Profile" width="25" height="25" class="me-2">
            <span>Sign Out</span>
          </a>
        </li>
      <!-- End Icons Nav -->

      <li class="nav-heading">JD Developer</li>
          <a class="nav-link collapsed" href="http://jdsoftdeveloper.kesug.com"  style="text-decoration: none;color: black">Copyright &copy; 2024 by JD Developer | All Rights Reserved</a> 

  </aside>
  <!-- End Sidebar-->

  <script src="../Admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../Admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../Admin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../Admin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="../Admin/assets/vendor/quill/quill.js"></script>
  <script src="../Admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../Admin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../Admin/assets/vendor/php-email-form/validate.js"></script>

  <script src="../Admin/js\main.js"></script>
</body>
<html>
