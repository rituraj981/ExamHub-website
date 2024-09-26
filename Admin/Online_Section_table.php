
<!-- Online_section_table.php -->

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
                  <a class="nav-link collapsed" href="Online_exam_panel.php">
                    <img src="image\back_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span>Back to Exam Dashborad</span>
                  </a> 
                </button>
                <button class="btn" type="button" style="float: right;">
                  <a class="nav-link collapsed" href="uploads/Question Paper file format.pdf" download="Question_File_Format">
                    <img src="image/excal_format.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span>Download Question file Format</span>
                  </a>
                </button>
            </div>
          </div>
        </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="card-body"style="margin: 10px 0;">
              <h3 class="panel-title">Online Exam List</h3>
				      <button type="button" id="add_button" class="" style="float: right; margin: -40px 10px; background: #2fa62f; color:#f9f9f9; padding: 5px 20px">Add Section Exam</button>
			      </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body"style="margin: 10px 0;">
              <!-- Table with stripped rows -->
              <table class="table datatable" id="exam_subject_data_table">
                <thead>
                  <tr>
                  <!-- <th><b>Exam</b>ID</th> -->
                    <th>Exam Code</th>
                    <th>Section Name</th>
                    <th>Total Question</th>
                    <th>Right Answer Mark</th>
					          <th>Wrong Answer Mark</th>
                    <th>View Questions</th>
                    <th>Edit/Delete</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      <div class="modal" id="formModal">
        <div class="modal-dialog modal-lg">
          <form method="post" action="exam_paper_add_show.php" id="exam_form" enctype="multipart/form-data">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title" id="modal_title"></h4>
                  <button type="button" class="close" id="closeButton" data-dismiss="modal" style="float: right; font-size: 21px; margin: -40px 10px; color: black; padding: 5px 20px">&times;</button>
                </div>
              <!-- Modal body -->
              <div class="modal-body">
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Exam Code<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="exam_code" id="exam_code" class="form-control">
                                  <option value="">Select Exam Code</option>
                                  <?php
                                      $admin_id = $_SESSION['admin_id'];
                                      $query = "SELECT `online_exam_id`, `admin_id`, `exam_code` FROM `online_exam_table` WHERE `admin_id` = ?";
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
                            <label class="col-md-4 text-right">Section Name<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="section_name" id="section_name" class="form-control" placeholder="Section Name" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total Question <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" name="total_question" id="total_question" class="form-control"  placeholder="Total Question">                                            
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Marks for Right Answer <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="number" name="marks_per_right_answer" id="marks_per_right_answer" class="form-control" placeholder="Marks for Right Answer" step="0.01" required/>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <label class="col-md-4 text-right">Marks for Wrong Answer <span class="text-danger">*</span></label>
                          <div class="col-md-8">
                              <input type="number" name="marks_per_wrong_answer" id="marks_per_wrong_answer" class="form-control" placeholder="Marks for Wrong Answer" step="0.01" required/>
                          </div>
                      </div>
                  </div>
                  <div class="form-group" id="questionDisplay">
                    <div class="row">
                      <label class="col-md-4 text-right">Upload CSV or Excel file <br> Size 10 MB in bytes<span class="text-danger">*</span></label>
                        <div class="col-md-8" id="questionsContainer">
                          <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <input type="hidden" name="subject_id" id="subject_id" />
                    <input type="hidden" name="page" value="add_subject" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-default" id="closeModalButton">Close</button>
                  </div>
                </div>
            </form>
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
  </section>
</main><!-- End #main -->
                                      
<script>
$(document).ready(function() {
    var dataTable = $('#exam_subject_data_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true, 
        "ordering": true, 
        "pageLength": 10,  
        "order": [], 
        "ajax": {     
            url: "ajax_action.php",
            method: "POST",
            data: { action: 'fetch', page: 'show_section_data' }
        },
        "columnDefs": [
            {
                "targets": [6],
                "orderable": false,
            },
        ],
        "columns": [
            { "data": "0" },  // Exam Code
            { "data": "1" },  // Subject Name
            { "data": "2" },  // Total Question
            { "data": "3" },  // Right Answer Mark
            { "data": "4" },  // Wrong Answer Mark
            { "data": "5" },  // Add Question button
            { "data": "6" }   // Edit/Delete buttons
        ]
    });

    function reset_form()
    {
      $('#modal_title').text('Add New Subject Details');
      $('#button_action').val('Add');
      $('#action').val('Add');
      $('#exam_form')[0].reset();
      $('#exam_form').parsley().reset();
    }

    $('#add_button').click(function(){
      reset_form();
      $('#formModal').modal('show');
      $('#message_operation').html('');
    });

    $('#exam_form').parsley();

  var exam_id = '';

	$(document).on('click', '.edit', function(){
		exam_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', exam_id:exam_id, page:'exam'},
			dataType:"json",
			success:function(data)
			{
				$('#online_exam_title').val(data.online_exam_title);

                $('#exam_code').val(data.exam_code);

				$('#online_exam_datetime').val(data.online_exam_datetime);

				$('#online_exam_duration').val(data.online_exam_duration);

				$('#total_question').val(data.total_question);

				$('#marks_per_right_answer').val(data.marks_per_right_answer);

				$('#marks_per_wrong_answer').val(data.marks_per_wrong_answer);

                $('#question_type').val(data.question_type);

				$('#online_exam_id').val(exam_id);

				$('#modal_title').text('Edit Exam Details');

				$('#button_action').val('Edit');

				$('#action').val('Edit');

				$('#formModal').modal('show');
			}
		})
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
                page: 'show_section_data'
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
    $('#closeButton, #closeModalButton').click(function() {
        $('#formModal').modal('hide');
    });
});

</script>

<!-- footer.php -->
<?php include('footer.php'); ?>

