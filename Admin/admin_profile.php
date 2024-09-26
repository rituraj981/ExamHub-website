<?php
// Include necessary files and start session
include('Admin_panel.php');

// Ensure the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection file (db_connect.php)
$conn = new mysqli('localhost', 'root', '', 'my_online_exam_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_table WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();




// Set default user icon if no profile image is set
$default_image = 'image/default_profile.png'; // Update this path to your default user icon
$admin_image = !empty($admin['admin_image']) ? $admin['admin_image'] : $default_image;

// Handle form submission for changing password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'change_password') {
        // Get form data
        $new_password = $_POST['new_password'];
        $renew_password = $_POST['renew_password'];

        // Validate the input
        if ($new_password === $renew_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $query = "UPDATE admin_table SET admin_password = ? WHERE admin_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $hashed_password, $admin_id);

            if ($stmt->execute()) {
                // Success message
                echo '<script>document.getElementById("popup_message").style.display = "block";</script>';
            } else {
                // Error message
                $message = "Failed to update password. Please try again.";
            }

            $stmt->close();
        } else {
            // Passwords do not match
            $message = "Passwords do not match.";
        }
    }

    if ($_POST['action'] == 'edit_profile') {
        // Get form data
        $admin_name = $_POST['full_name'];
        $admin_email_address = $_POST['email'];
        $admin_type = $_POST['admin_type'];

        // Handle profile image upload
        $target_dir = "upload_image/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_image_name = uniqid() . '.' . $imageFileType;
        $target_path = $target_dir . $new_image_name;
        $uploadOk = 1;

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;  
            } else {
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_image"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_path)) {
                // Update admin details including profile image
                $query = "UPDATE admin_table SET admin_name = ?, admin_email_address = ?, admin_type = ?, admin_image = ? WHERE admin_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('ssisi', $admin_name, $admin_email_address, $admin_type, $target_path, $admin_id);
                
                if ($stmt->execute()) {
                    // Success message
                    $message = "Profile updated successfully.";
                } else {
                    // Error message
                    $message = "Failed to update profile. Please try again.";
                }
                
                $stmt->close();
            } else {
                // Error message
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// Re-fetch updated admin details after form submission
$query = "SELECT * FROM admin_table WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();
?>

<!-- Add a hidden div for the popup message -->
<div id="popup_message" style="display: none; position: fixed; top: 80px; right: 20px; background: #4caf50; color: white; padding: 15px; border-radius: 5px;">
    Password successfully updated!
</div>
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
                        <img src="<?php echo $admin['admin_image']; ?>" alt="Profile" class="rounded-circle mb-3" style="width: 200px; height: 220px; border: 1px solid black;">
                        <h2><?php echo $admin['admin_name']; ?></h2>
                        <h3><?php echo $admin['admin_type'];?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Admin Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $admin['admin_name']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email Address</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $admin['admin_email_address']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Admin Type</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $admin['admin_type']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Join Time</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $admin['admin_created_on']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email Verified</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $admin['email_verified'] ? 'Yes' : 'No'; ?></div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form method="post" enctype="multipart/form-data">
                                    
                                <div class="row mb-3">
                                        <label for="profile_image" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?php echo $admin['admin_image']; ?>" id="profileImagePreview" alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px;border: 1px solid black;">
                                            <input type="file" name="profile_image" class="form-control" id="profile_image" onchange="previewImage(event)">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Admin Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="full_name" type="text" class="form-control" id="fullName" value="<?php echo $admin['admin_name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="email" value="<?php echo $admin['admin_email_address']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="admin_type" class="col-md-4 col-lg-3 col-form-label">Admin Type</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="admin_type" class="form-control" id="admin_type" required>
                                            <option value="0" <?php echo $admin['admin_type'] == 0 ? 'selected' : ''; ?>>Select</option>
                                                <option value="1" <?php echo $admin['admin_type'] == 1 ? 'master' : ''; ?>>Master Admin</option>
                                                <option value="2" <?php echo $admin['admin_type'] == 2 ? 'sub-master' : ''; ?>>Sub-Master Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="hidden" name="action" value="edit_profile">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings">
                                <!-- Settings Form -->
                                <form>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                        <div class="col-md-8 col-lg-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                <label class="form-check-label" for="changesMade">
                                                    Changes made to your account
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                <label class="form-check-label" for="newProducts">
                                                    Information on new products and services
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="proOffers">
                                                <label class="form-check-label" for="proOffers">
                                                    Marketing and promo offers
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                                <label class="form-check-label" for="securityNotify">
                                                    Security alerts
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End settings Form -->
                            </div>

                            <!-- Change Password Form -->
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form method="post" id="change_password_form">
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password" class="form-control" id="new_password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renew_password" type="password" class="form-control" id="renew_password" required data-parsley-equalto="#new_password">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="hidden" name="page" value="change_password">
                                        <input type="hidden" name="action" value="change_password">
                                        <input type="hidden" name="admin_id" value="<?php echo $_SESSION['admin_id']; ?>">
                                        <input type="submit" class="btn btn-primary" value="Change Password">
                                    </div>
                                </form>
                            </div>
                            <!-- End Change Password Form -->
                        </div>
                        <!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>

<script>
    // JavaScript to close the popup message after 3 seconds
    setTimeout(function() {
        document.getElementById('popup_message').style.display = 'none';
    }, 3000);

    // JavaScript function to preview the uploaded image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profileImagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>