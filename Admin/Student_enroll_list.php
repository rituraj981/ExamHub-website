
<?php

//Dashboard_Panel.php

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
              <h3 class="panel-title">Exam Student List</h3>
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body"style="margin: 10px 0;">
                  <table id="User_enroll_data" class="table datatable">
                    <thead>
                      <tr>
                        <th>student Enroll ID</th>
                        <th>User ID</th>
                        <th>Exam ID</th>
                        <th>Attempted Status</th>
                      </tr>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  $(document).ready(function() {
    $('#User_enroll_data').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        url: "ajax_action.php",
        type: "POST",
        data: { action: 'fetch', page: 'view_student_enroll_data' }
      },
      "columnDefs": [
        {
          "targets": [0],
          "orderable": false
        }
      ]
    });
  });
</script>

<?php

//footer.php

include('footer.php');

?>