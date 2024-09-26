<?php

//Dashboard_Panel.php

include('Admin_panel.php');

?>
<style>
    .info-cards {
        margin: 0 10px;
        /* width: 25%; */
        display: flex;
        border-radius: 15px;
        border: solid 0px 0 30px rgba(47, 88, 126, 0.1);
        box-shadow: 0px 0 30px rgba(2, 59, 112, 0.1);
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Organisation Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
          <li class="breadcrumb-item active">Organisation Profile</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class="items_bar">
                    <div class="info-cards">
                        <div class="card-body">
                            <img src="image/master-admin.png" alt="Profile" width="60" height="60">
                            <span>Lokesh Kumar saini</span> <br>
                            <span>lokeshsuiwal282@gmail.com</span>
                            <div class="ps-2" style="text-align: center;">
                                <a href="organisation_logo_profile.php" class="btn btn-warning btn-sm">Edit Logo &amp; Theme</a>
                            </div>
                        </div>
                    </div>
                    <div class="info-cards">
                        <div class="card-body">
                            <img src="image/eye-examiner.png" alt="Profile" width="60" height="60" >
                            <span>Account Status</span> <br>
                            <span>Account active date</span><br>
                            <span>05/05/2024 12:30:00</span>
                            <div class="ps-2" style="text-align: center;">
                                <a href="admin_profile.php" class="btn btn-info btn-sm">Edit Logo &amp; Theme</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="info-cards revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #ec2984;">Pending Exam(s)</h5>
                            <div class="ps-3">
                                <span id="pending_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1cc4ee;">Completed Exam(s)</h5>
                            <div class="ps-3">
                                <span id="completed_count">0</span>
                            </div>
                        </div>
                    </div> -->
                </div>

<?php include('footer.php'); ?>
