<?php
include('Admin_panel.php');
?>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Student panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
          <li class="breadcrumb-item active">Student</li>
          <li class="breadcrumb-item active" aria-current="page">Exam Enrollment List</li>
        </ol>
      </nav>
    </div>
    <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-8" style="margin: auto;">
                        <select name="exam_type_student" id="exam_type_student" class="form-control">
                            <option value="">Select Exam Type</option>
                              <?php
                                $admin_id = $_SESSION['admin_id'];
                                $query = "SELECT `online_exam_id`, `admin_id`, `online_exam_title`, `exam_code` FROM `online_exam_table` WHERE `admin_id` = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $admin_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['exam_code'] . '">' . htmlspecialchars($row['online_exam_title']) . '</option>';
                                }

                                $stmt->close();
                              ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <div class="row">
        <div class="col-lg-12">
          <h3 class="panel-title">Exam Enrollment List</h3>
          <div class="card recent-sales overflow-auto">
            <div class="card-body" style="margin: 10px 0;">
              <table id="User_table_data" class="table datatable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>User Name</th>
                        <th>Enrollment ID</th>
                        <th>Exam Code</th>
                        <th>Email ID</th>
                        <th>Gender</th>
                        <th>Mobile No.</th>
                        <th>Email Status</th>
                    </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  $(document).ready(function() {
    function loadTable(exam_code = '') {
      var dataTable = $('#User_table_data').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "order": [],
        "ajax": {
          url: "ajax_action.php",
          type: "POST",
          data: {
            action: 'fetch',
            page: 'view_user_data',
            exam_code: exam_code
          }
        },
        "columnDefs": [
          {
            "targets": [0],
            "orderable": false
          }
        ]
      });
    }

    // Load table on page load
    loadTable();

    // Reload table when exam type changes
    $('#exam_type_student').change(function() {
      var exam_code = $(this).val();
      $('#User_table_data').DataTable().destroy();
      loadTable(exam_code);
    });
  });
</script>

<?php
include('footer.php');
?>
