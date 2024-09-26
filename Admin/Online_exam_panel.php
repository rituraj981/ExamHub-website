<?php

//Home_Panel.php

include('Admin_panel.php');

?>

<?php
  if(isset($_SESSION['admin_id'])) {
      $admin_id = $_SESSION['admin_id'];

      // Prepare the SQL statement with placeholders
      $sql = "SELECT online_exam_status, COUNT(*) as count FROM online_exam_table WHERE admin_id = ? GROUP BY online_exam_status";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $admin_id);
      $stmt->execute();
      
      // Get the result
      $result = $stmt->get_result();

      // Initialize counters
      $total_count = 0;
      $pending_count = 0;
      $active_count = 0;
      $created_count = 0;
      $completed_count = 0;

      // Process the result
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $total_count += $row['count'];
              switch ($row['online_exam_status']) {
                  case 'Pending':
                      $pending_count = $row['count'];
                      break;
                  case 'Started':
                      $active_count = $row['count'];
                      break;
                  case 'Created':
                      $created_count = $row['count'];
                      break;
                  case 'Completed':
                      $completed_count = $row['count'];
                      break;
              }
          }
      } else {
          echo "0 results";
      }

      // Close the statement and the connection
      $stmt->close();
      $conn->close();

  } else {
      echo "No admin logged in.";
  }
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Online Exam System</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
            <li class="breadcrumb-item">Online Examination</li>
            <li class="breadcrumb-item active">Exam</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="button_items">
                  <button id="actionBtn" class="hide btn">action
                    <i class="bi bi-chevron-down ms-auto"></i>
                    </button>
                  <div id="buttonList">
                    <div class="sidebar-nav">                 
                      <button class="btn" id="addExamBtn">
                        <a class="nav-link collapsed" href="Online_exam_table.php">
                          <img src="image\exam.png" alt="Student Panel" width="25" height="25" class="me-2">
                          <span>Add Exam</span>
                        </a> 
                      </button>
                    </div>
                    <div class="sidebar-nav">
                      <button class="btn" id="updateExamInstructionsBtn">
                        <a class="nav-link collapsed" href="update_exam_instructions.php">
                          <img src="image\messages_icon.png" alt="Student Panel" width="25" height="25" class="me-2">
                          <span>Update Exam Instructions</span>
                        </a> 
                      </button>
                    </div>
                    <div class="sidebar-nav">
                      <button class="btn" id="updateQuestionPaperInstructionsBtn">
                        <a class="nav-link collapsed" href="update_paper_instructions.php">
                          <img src="image\education.png" alt="Student Panel" width="25" height="25" class="me-2">
                          <span>Update Question Paper Instructions</span>
                        </a>
                      </button>
                    </div>
                      <script>
                        // script.js
                        document.addEventListener("DOMContentLoaded", function() {
                          var actionBtn = document.getElementById('actionBtn');
                          var buttonList = document.getElementById('buttonList');

                          actionBtn.addEventListener('click', function() {
                            if (buttonList.style.display === 'none') {
                              buttonList.style.display = 'block';
                            } else {
                              buttonList.style.display = 'none';
                            }
                          });
                        });
                      </script>
                  </div>
                  <div class="items_bar">
                    <div class="info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: black;">Total Exam(s)</h5>
                            <div class="ps-3">
                                <span id="total_count"><?php echo $total_count; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: green;">Action Exam(s)</h5>
                            <div class="ps-3">
                                <span id="active_count"><?php echo $active_count; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1260f7;">Created Exam(s)</h5>
                            <div class="ps-3">
                                <span id="created_count"><?php echo $created_count; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #ec2984;">Pending Exam(s)</h5>
                            <div class="ps-3">
                                <span id="pending_count"><?php echo $pending_count; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1cc4ee;">Completed Exam(s)</h5>
                            <div class="ps-3">
                                <span id="completed_count"><?php echo $completed_count; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Revenue Card -->
                <div class="col-12">
                  <div class="card recent-sales overflow-auto">
                    <div class="card-body" style="margin: 10px 0;">
                      <!-- Table with stripped rows -->
                      <table class="table datatable" id="exam_data">
                        <thead>
                          <tr>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Total Question</th>
                            <th scope="col">Created On Time</th>     
                            <th scope="col">Result Date & Time</th>
                            <th scope="col">Exam Code</th>
                            <th scope="col">Status</th>
                            <!-- <th scope="col">View Question Paper</th> -->
                            <th scope="col">Action</th>                                         
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="publishresultModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="publish_result_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Publish Exam Result</h4>
                            <button type="button" id="closeModalButton" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">                    
                            <div class="form-group">
                                <label>Exam Result Publish Date & Time</label>
                                <input type="text" name="exam_result_publish_datetime" id="exam_result_publish_datetime" class="form-control datepicker" readonly required data-parsley-trigger="keyup" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="hidden_exam_id" id="hidden_exam_id" />
                            <input type="hidden" name="action" id="action" value="Result Publish" />
                            <input type="submit" name="submit" id="result_publish_submit_button" class="btn btn-success" value="Publish" />
                            <button type="button" class="btn btn-default" id="closeButton" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
  </section>
</main>

  <script>
   $(document).ready(function(){
    var dataTable = $('#exam_data').DataTable({
        "processing" : true,
        "serverSide" : true,
        "searching": true, // Enable searching
        "ordering": true,  // Enable ordering
        "pageLength": 10,  // Display all rows on one page
        "order": [],       // Disable initial sorting
        "ajax" : {
            url: "ajax_action.php",
            method:"POST",
            data:{action:'fetch', page:'View_exam_details'}
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
            { "data": "4" },
            { "data": "5" },
            { "data": "6" },
            // { "data": "7" }
        ]
    });

    $('#exam_result_publish_datetime').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true
            });

            // Click event to fetch data and show modal
            $(document).on('click', '.publish_result', function() {
                var exam_id = $(this).data('exam_id');
                $.ajax({
                    url: "ajax_action.php",
                    method: "POST",
                    data: { exam_id: exam_id, action: "fetch_result_publish_data" },
                    success: function(data) {
                        if (data) {
                            $('#exam_result_publish_datetime').val(data);
                        }
                        $('#publishresultModal').modal('show');
                        $('#hidden_exam_id').val(exam_id);
                    }
                });
            });

            // Initialize Parsley for form validation
            $('#publish_result_form').parsley();

            // Form submit event
            $('#publish_result_form').on('submit', function(event) {
                event.preventDefault();
                if ($(this).parsley().isValid()) {
                    $.ajax({
                        url: "ajax_action.php",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            $('#result_publish_submit_button').attr('disabled', 'disabled');
                            $('#result_publish_submit_button').val('waiting...');
                        },
                        success: function(data) {
                            $('#result_publish_submit_button').attr('disabled', false);
                            $('#publishresultModal').modal('hide');
                            $('#message').html(data.success);
                            dataTable.ajax.reload();
                            setTimeout(function() {
                                $('#message').html('');
                            }, 5000);
                        }
                    });
                }
            });

      $('#closeButton, #closeModalButton').click(function() {
        $('#publishresultModal').modal('hide');
    });

  });

  </script>
<?php include('footer.php'); ?>
