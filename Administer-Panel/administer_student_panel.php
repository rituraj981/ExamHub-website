<?php
include('administer_panel.php');
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
                        <th>Status</th>
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
    var dataTable = $('#User_table_data').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "order": [],
        "ajax": {
            url: "administer_action.php",
            type: "POST",
            data: {
                action: 'fetch',
                page: 'view_user_data'
            }
        },
        "columnDefs": [
            {
                "targets": [0],
                "orderable": false
            }
        ]
    });

    // Handle status update on button click
    $('#User_table_data').on('click', '.status-button', function() {
        var user_id = $(this).data('user-id');
        var new_status = $(this).data('status') === 'yes' ? 'no' : 'yes';
        $.ajax({
            url: 'update_status.php', // Updated URL
            type: 'POST',
            data: {
                action: 'update_status',
                user_id: user_id,
                status: new_status
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.user_email_verified) {
                    dataTable.ajax.reload(null, false);
                    alert('Student are Present updated successfully');
                } else {
                    alert('Failed to update status');
                }
            }
        });
    });
});
</script>
<?php
include('footer.php');
?>
