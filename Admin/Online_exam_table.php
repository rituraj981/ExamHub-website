<?php
// Online_exam_table.php

include('Admin_panel.php');
?>
    <style>
        .valid-icon {
            display: none;
            color: green;
            margin-left: 10px;
            font-size: 1.5em;
            align-self: center;
        }
    </style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Exam Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item">Online Examination</li>
                <li class="breadcrumb-item active">Exam Tables</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12 sidebar-nav">
                <button class="btn">
                  <a class="nav-link collapsed" href="Online_exam_panel.php">
                    <img src="image\back_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span>  Back</span>
                  </a> 
                </button>
                <button class="btn">
                  <a class="nav-link collapsed" href="Online_Section_table.php">
                  <span>Add to Section Wise Exam / Question</span>
                    <img src="image\forward_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                  </a> 
                </button>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body" style="margin: 10px 0;">
                    <h3 class="panel-title">Online Exam List</h3>
                    <button type="button" id="add_button" class="" style="float: right; margin: -40px 10px; background: #2fa62f; color:#f9f9f9; padding: 5px 20px">Add Exam</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body" style="margin: 10px 0;">
                    <!-- Table with stripped rows -->
                    <table class="table datatable" id="exam_data_table">
                        <thead>
                            <tr>
                                <th>Exam Name</th>
                                <th>Date & Time</th>
                                <th>Question Time</th>
                                <th>Total Question</th>
                                <th>Right Answer Mark</th>
                                <th>Wrong Answer Mark</th>
                                <th>Exam Type</th>
                                <th>Edit/Delete</th>
                            </tr>
                            <div id="exam_subject_table_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
                        </thead>
                    </table>
                    <!-- End Table with stripped rows -->
                    <div id="formModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <form method="post" id="exam_form">
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
                                                <label class="col-md-4 text-right">Exam Title <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="online_exam_title" id="online_exam_title" class="form-control" placeholder="Exam Name" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Exam Code <span class="text-danger">*</span></label>
                                                <div class="col-md-8 d-flex">
                                                    <input type="text" name="exam_code" id="exam_code" class="form-control" placeholder="Exam Code" required />
                                                    <button type="button" class="btn btn-warning btn-sm ml-2" id="check_code_btn">Check</button>
                                                    <span class="valid-icon" id="valid_icon">&#10003;</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Exam Date & Time <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="online_exam_datetime" id="online_exam_datetime" class="form-control" placeholder="Exam Date & Time" readonly required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Exam Duration <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="number" name="online_exam_duration" id="online_exam_duration" class="form-control" placeholder="Exam Duration(Minute)" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Total Question <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="number" name="total_question" id="total_question" class="form-control" placeholder="Total Question" required/>
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
                                        <style>
                                            #otherInputDiv {
                                                display: none;
                                            }
                                        </style>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Exam Type <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <select name="question_type" id="question_type" class="form-control" required>
                                                        <option value="">Select Exam Type</option>
                                                        <option value="Multiple Choice Exam">Multiple Choice Exam</option>
                                                        <option value="Generative AI Exam">Generative AI Exam</option>
                                                        <option value="Programming/SQL Exam">Programming/SQL Exam</option>
                                                        <option value="Subjective/Theory Exam">Subjective/Theory Exam</option>
                                                        <option value="Both(MCQ + Sub)">Both(MCQ + Sub)</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="otherInputDiv">
                                            <div class="row">
                                                <label class="col-md-4 text-right">Please Specify <span class="text-danger">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" name="other_exam_type" id="other_exam_type" class="form-control" placeholder="Enter exam type" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <input type="hidden" name="online_exam_id" id="online_exam_id" />
                                        <input type="hidden" name="page" value="exam" />
                                        <input type="hidden" name="action" id="action" value="Add" />
                                        <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" disabled />
                                        <button type="button" class="btn btn-default" id="closeModalButton">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal" id="deleteModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Confirmation</h4>
                                    <button type="button" class="close"  id="closeButton" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <h3 align="center">Are you sure you want to remove this?</h3>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="closeModalButton" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<script>
    $(document).ready(function() {
        var dataTable = $('#exam_data_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "ajax_action.php",
                method: "POST",
                data: { action: 'fetch', page: 'exam' }
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

        function reset_form() {
            $('#modal_title').text('Add Exam Details');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#exam_form')[0].reset();
            $('#exam_form').parsley().reset();
        }

        $('#add_button').click(function() {
            reset_form();
            $('#formModal').modal('show');
            $('#message_operation').html('');
        });

        $('#online_exam_datetime').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true
        });

        $('#question_type').on('change', function() {
            var otherInputDiv = document.getElementById('otherInputDiv');
            if (this.value === 'Other') {
                otherInputDiv.style.display = 'block';
            } else {
                otherInputDiv.style.display = 'none';
            }
        });

        $('#exam_form').parsley();

        $('#exam_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#exam_form').parsley().validate()) {
                $.ajax({
                    url: "ajax_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#button_action').attr('disabled', 'disabled');
                        $('#button_action').val('Validate...');
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                            reset_form();
                            dataTable.ajax.reload();
                            $('#formModal').modal('hide');
                        }
                        $('#button_action').attr('disabled', false);
                        $('#button_action').val($('#action').val());
                    }
                });
            }
        });

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

        $('#check_code_btn').click(function() {
            var examCode = $('#exam_code').val();
            $.ajax({
                url: 'check_exam_code.php', // Update the path as needed
                method: 'POST',
                data: { exam_code: examCode },
                dataType: 'json',
                success: function(response) {
                    if (response.exists) {
                        alert("Exam Code already saved in database table.");
                        $('#valid_icon').hide();
                        $('#button_action').prop('disabled', true);
                    } else {
                        $('#valid_icon').show();
                        $('#button_action').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        });


        $(document).on('click', '.delete', function() {
            exam_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "ajax_action.php",
                method: "POST",
                data: { exam_id: exam_id, action: 'delete', page: 'exam' },
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


<!-- footer.php -->
<?php include('footer.php'); ?>

