<!-- Online_exam_table.php -->

<?php include('Admin_panel.php'); ?>

<!-- this code are main file code in project -->
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Exam Tables</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
            <li class="breadcrumb-item"><a href="Online_exam_panel.php">Online Examination</a></li>
            <li class="breadcrumb-item active">Exam Tables</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
          <div class="col-lg-12">
            <div class="sidebar-nav">
                <button class="btn">
                  <a class="nav-link collapsed" href="Online_Section_table.php">
                    <img src="image\back_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span> Back to Section Table</span>
                  </a> 
                </button> 
                <button class="btn">
                  <a class="nav-link collapsed" href="Online_exam_panel.php">
                    <img src="image\up_arrow_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span> Back to Exam Dashborad</span>
                  </a> 
                </button>
            </div>
          </div>
        </div>
      <div class="row">
        <div class="col-lg-12">
          <!-- <div class="card"> -->
            <div class="card-body"style="margin: 3px 0;">
              <h3 class="panel-title">Online Exam Question Paper Lists</h3>
			      </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body"style="margin: 4px 0;">
              <!-- Table with stripped rows -->
              <table class="table datatable" id="exam_question_paper_table">
                <thead>
                  <tr>
                    <th><b>Exam Code</th>
                    <th>Section Name</th>
                    <th>Question</th>
                    <th>Opction 1</th>
                    <th>Opction 2</th>
                    <th>Opction 3</th>
                    <th>Opction 4</th>
                    <!-- <th>Answer</th> -->
                    <th>Edit/Delete</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

        <div class="modal" id="deleteModal">
          <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                      <h4 class="modal-title">Delete Confirmation</h4>
                      <button type="button" id="closeButton" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                      <h3 align="center">Are you sure you want to remove this?</h3>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                      <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
                      <button type="button" id="closeButton" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>
      <!-- End Table with stripped rows -->
<script>
  $(document).ready(function() {
      var subject_id = new URLSearchParams(window.location.search).get('subject_id');

      var dataTable = $('#exam_question_paper_table').DataTable({
          "processing": true,
          "serverSide": true,
          "searching": true,
          "ordering": true,
          "pageLength": 10,
          "order": [],
          "ajax": {
              url: "ajax_action.php",
              method: "POST",
              data: {
                  action: 'fetch',
                  page: 'view_section_wise_question',
                  subject_id: subject_id
              }
          },
          "columnDefs": [
              {
                  "targets": [7],
                  "orderable": false,
              },
          ],
          "columns": [
              { "data": "0" },
              { "data": "1" },
              { "data": "2" },
              { "data": "3" },
              { "data": "4" },
              { "data": "5" },
              { "data": "6" },
              { "data": "7" }
          ]
      });

      $('#upload_form').on('submit', function(event) {
          event.preventDefault();
          $.ajax({
              url: "ajax_action.php",
              method: "POST",
              data: new FormData(this),
              dataType: 'json',
              contentType: false,
              cache: false,
              processData: false,
              success: function(data) {
                  if (data.error != '') {
                      $('#message').html('<div class="alert alert-danger">' + data.error + '</div>');
                  } else {
                      $('#process_area').html(data.output);
                      $('#upload_area').css('display', 'none');
                  }
              }
          });
      });

      $(document).on('click', '.delete', function(){
        exam_id = $(this).attr('id');
        $('#deleteModal').modal('show');
      });

      $('#ok_button').click(function(){
          $.ajax({
              url: "ajax_action.php",
              method: "POST",
              data: {
                  exam_id: exam_id, 
                  action: 'delete', 
                  page: 'view_section_wise_question'
              },
              dataType: "json",
              success: function(data) {
                  $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                  $('#deleteModal').modal('hide');
                  dataTable.ajax.reload();
              }
          });
      });
      $('#closeButton, #closeModalButton').click(function() {
        $('#deleteModal').modal('hide');
    });
  });
</script>