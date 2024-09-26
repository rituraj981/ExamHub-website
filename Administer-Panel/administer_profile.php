<?php
    // Include necessary files and start session
    include('Administer_panel.php');
    include '../mainfile.php';

    // Ensure the user is logged in
    if (!isset($_SESSION['administer_id'])) {
        header('Location: logout.php');
        exit();
    }
  
    $administer_id = $_SESSION['administer_id'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT `administer_id`, `admin_id`, `administer_name`, `exam_code`, `administer_email_address`, `administer_password`, `administer_type`, `administer_created_on`, `administer_email_verified` FROM `administer_table` WHERE `administer_id` = ?");
    $stmt->bind_param("i", $administer_id);

    $stmt->execute();

    $stmt->bind_result($administer_id, $admin_id, $administer_name, $exam_code, $administer_email_address, $administer_password, $administer_type, $administer_created_on, $administer_email_verified);
    
    $stmt->fetch();

    $stmt->close();
    $conn->close();
?>


<main id="main" class="main">
    <!-- Content goes here -->
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="../Admin\image\default_profile.png" alt="Profile" class="rounded-circle mb-3" style="width: 220px; height: 220px">
                        <h2><?php echo htmlspecialchars($administer_name); ?></h2>
                        <h3><?php echo htmlspecialchars($administer_type); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Administer Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($administer_name); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Exam Code</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($exam_code); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email Address</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($administer_email_address); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Administer Type</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($administer_type); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Join Time</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($administer_created_on); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email Verified</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($administer_email_verified); ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>
