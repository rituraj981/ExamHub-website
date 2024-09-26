<?php
// session_start();
include('Admin_panel.php');


// Handle form submission for adding and editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $administer_name = $_POST['administer_name'] ?? '';
    $exam_code = $_POST['exam_code'] ?? '';
    $administer_email_address = $_POST['administer_email_address'] ?? '';
    $administer_password = password_hash($_POST['administer_password'], PASSWORD_DEFAULT);
    $administer_type = $_POST['administer_type'] ?? '';
    $administer_email_verified = $_POST['administer_email_verified'] ?? 'no';
    $admin_id = $_SESSION['admin_id'] ?? 0;  // Get the logged-in admin's ID
    $administer_created_on = date('Y-m-d H:i:s');  // Get the current date and time

    if (empty($administer_name) || empty($exam_code) || empty($administer_email_address) || empty($administer_type)) {
        echo "<script>alert('Please fill all required fields.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if ($_POST['action'] == 'Add') {
        $query = "INSERT INTO administer_table (admin_id, administer_name, exam_code, administer_email_address, administer_password, administer_type, administer_email_verified, administer_created_on) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssssss", $admin_id, $administer_name, $exam_code, $administer_email_address, $administer_password, $administer_type, $administer_email_verified, $administer_created_on);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Administer/Examiner added successfully!');</script>";
        echo "<script>window.location.href='organisation_administer_admin_panel.php';</script>";
    } elseif ($_POST['action'] == 'Edit') {
        $administer_id = $_POST['administer_id'];
        $query = "UPDATE administer_table 
                  SET administer_name = ?, exam_code = ?, administer_email_address = ?, administer_password = ?, administer_type = ?, administer_email_verified = ?, administer_created_on = ?
                  WHERE administer_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $administer_name, $exam_code, $administer_email_address, $administer_password, $administer_type, $administer_email_verified, $administer_created_on, $administer_id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Administer/Examiner updated successfully!');</script>";
        echo "<script>window.location.href='admin_manage.php';</script>";
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Exam Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item"><a href="">Organisation</a></li>
                <li class="breadcrumb-item active">Administer/Examiner Data Tables</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body" style="margin: 10px 0;">
                    <h3 class="panel-title">Administer/Examiner List</h3>
                    <button type="button" id="add_button" class="btn" style="float: right; margin: -40px 200px; background: #2fa62f; color:#f9f9f9; padding: 5px 20px">Add to Administer/Examiner</button>
                     <button class="btn" style="float: right; margin: -40px 0px; background: #2fa62f; color:#f9f9f9; padding: 5px 20px"><a class="nav-link collapsed" href="organisation_administer_examiner_notification.php">
                    <span>Send Notification</span>
                  </a> 
                </button>
                </div>
            </div>
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body" style="margin: 4px 0;">
                        <table class="table datatable" id="add_to_administer_data_table">
                            <thead>
                                <tr>
                                    <th>Administer/Examiner Name</th>
                                    <th>Exam Code</th>
                                    <th>Email Address</th>
                                    <th>Admin Type</th>
                                    <th>Join DateTime</th>
                                    <th>Email Verified</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div class="modal" id="formModal">
            <div class="modal-dialog modal-lg">
                <form method="post" id="administer_examiner_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title"></h4>
                            <button type="button" class="close" id="closeButton" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Administer/Examiner Name<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="administer_name" id="administer_name" class="form-control" placeholder="Administer/Examiner Name" required data-parsley-pattern="^[a-zA-Z ]+$"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Exam Code<span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <select name="exam_code" id="exam_code" class="form-control">
                                            <option value="">Select Exam Code</option>
                                            <?php
                                                $admin_id = $_SESSION['admin_id'];
                                                $query = "SELECT online_exam_id, admin_id, exam_code FROM online_exam_table WHERE admin_id = ?";
                                                $stmt = $conn->prepare($query);
                                                $stmt->bind_param("i", $admin_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['exam_code']) . '">' . htmlspecialchars($row['exam_code']) . '</option>';
                                                }

                                                $stmt->close();
                                            ?>                     
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Email Address<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="email" name="administer_email_address" id="administer_email_address" class="form-control" placeholder="Email Address" required data-parsley-type="email" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Password<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="password" name="administer_password" id="administer_password" class="form-control" placeholder="Password" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Confirm Password<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="password" name="confirm_administer_password" id="confirm_administer_password" class="form-control" placeholder="Confirm Password" required data-parsley-equalto="#administer_password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Admin Type<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select name="administer_type" id="administer_type" class="form-control" required>
                                            <option value="Administer">Administer</option>
                                            <option value="Examiner">Examiner</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Email Verified<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select name="administer_email_verified" id="administer_email_verified" class="form-control" required>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="submit" name="administer_register" id="administer_register" class="btn btn-success btn-sm" value="Add"/>
                            <button type="button" class="btn btn-default" id="closeModalButton">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" id="closeModalButton" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h3 align="center">Are you sure you want to remove this?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
                        <button type="button" class="btn btn-danger btn-sm" id="closeButton" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- footer.php -->
<?php include('footer.php'); ?>

<script>

   $(document).ready(function() {
        var dataTable = $('#add_to_administer_data_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "ajax_action.php",
                method: "POST",
                data: { action: 'fetch', page: 'add_administer_examiner_data' }
            },
            "columnDefs": [
                {
                    "targets": [6],
                    "orderable": false,
                },
            ],
            "columns": [
                { "data": "0" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" }

            ]
        });

        function reset_form() {
            $('#modal_title').text('Add New Administer/Examiner');
            $('#administer_register').val('Add');
            $('#action').val('Add');
            $('#administer_examiner_form')[0].reset();
            $('#administer_examiner_form').parsley().reset();
        }

        $('#add_button').click(function() {
            reset_form();
            $('#formModal').modal('show');
        });

        $('#administer_examiner_form').parsley();

        $('#administer_examiner_form').on('submit', function(event) {
            if ($('#administer_examiner_form').parsley().isValid()) {
                return true;
            }
            return false;
        });

        // $('#administer_examiner_form').on('submit', function(event) 
        // {
        //     event.preventDefault();
        //     if ($('#administer_examiner_form').parsley().validate()) {
        //         $.ajax({
        //             url: "ajax_action.php",
        //             method: "POST",
        //             data: $(this).serialize(),
        //             dataType: "json",
        //             beforeSend: function() {
        //                 $('#administer_register').attr('disabled', 'disabled');
        //                 $('#administer_register').val('Validate...');
        //             },
        //             success: function(data) {
        //                 if (data.success) {
        //                     $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
        //                     reset_form();
        //                     dataTable.ajax.reload();
        //                     $('#formModal').modal('hide');
        //                 }
        //                 $('#administer_register').attr('disabled', false);
        //                 $('#administer_register').val($('#action').val());
        //             }
        //         });
        //     }
        // });

        $(document).on('click', '.delete', function() {
            exam_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "ajax_action.php",
                method: "POST",
                data: { exam_id: exam_id, action: 'delete', page: 'add_administer_examiner_data' },
                dataType: "json",
                success: function(data) {
                    $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                    $('#deleteModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        });

        $('#closeButton, #closeModalButton').click(function() {
            $('#formModal').modal('hide');
        });
        $('#closeButton, #closeModalButton').click(function() {
            $('#deleteModal').modal('hide');
        });
    });
</script>