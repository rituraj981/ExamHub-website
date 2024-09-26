<?php
    include('Admin_panel.php');

    function fetchResultData($exam_code) {
        global $conn;
        $stmt = $conn->prepare("SELECT `id`, `user_id`, `exam_code`, `user_name`, `enrollment_number`, `exam_name`, `total_question`, `attempted_questions`, `not_attempted_questions`, `total_right_answers`, `total_wrong_answers`, `maximum_marks`, `negative_marks`, `total_marks`, `user_marks`, `percentage` FROM `calculation_result_data` WHERE exam_code = ?");
        $stmt->bind_param("s", $exam_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    $results = [];
    if (isset($_GET['exam_code'])) {
        $exam_code = $_GET['exam_code'];
        $results = fetchResultData($exam_code);
    }
?>

<?php
    function SectionResultData($exam_code) {
        global $conn;
        $stmt = $conn->prepare("SELECT `id`, `user_id`, `exam_code`, `user_name`, `enrollment_number`, `exam_name`, `total_question`, `attempted_questions`, `not_attempted_questions`, `total_right_answers`, `total_wrong_answers`, `maximum_marks`, `negative_marks`, `total_marks`, `user_marks`, `percentage` FROM `calculation_result_data` WHERE exam_code = ?");
        $stmt->bind_param("s", $exam_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    function SectionWiseData($user_id, $exam_code) {
        global $conn;
        $stmt = $conn->prepare("SELECT `id`, `admin_id`, `user_id`, `exam_code`, `section_name`, `total_questions`, `minimum_mark`, `negative_mark`, `total_mark`, `user_mark`, `percentagee` FROM `section_calculation_result_data` WHERE user_id = ? AND exam_code = ?");
        $stmt->bind_param("is", $user_id, $exam_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    $results = [];
    if (isset($_GET['exam_code'])) {
        $exam_code = $_GET['exam_code'];
        $results = SectionResultData($exam_code);
    }
?>

<style>
   
    /* #result_table th, #result_table td {
        border: 1px solid #524c4c
    }
    #result_table {
        border-collapse: collapse;
        width: 100%;
    } */
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Exam Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item">View Exam Result</li>
                <li class="breadcrumb-item active">Result Tables</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body"style="margin: 10px 0;">
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="exam_data">
                            <thead>
                                <tr>
                                    <th scope="col">Exam Name</th>
                                    <th scope="col">Exam Code</th>
                                    <th scope="col">Total Question</th>
                                    <th scope="col">Created On Time</th>
                                    <th scope="col">Result Date & Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($results)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="panel-title">Result Table</h3>
                    <div class="card">
                        <div class="card-body"style="margin: 10px 0;">
                            <div class="table-responsive">
                                <div style="float: right; margin: 10px 4px;">
                                    <button id="exportCSV" class="btn btn-primary">Donwload (CSV)</button>
                                </div>
                                <table id="result_table" class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Exam Code</th>
                                            <th>Student Name</th>
                                            <th>Enrollment Number</th>
                                            <th>Total Question</th>
                                            <th>Maximum Marks</th>
                                            <!-- <th>Negative Marks</th> -->
                                            <th>Marks</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $serial = 1; ?>
                                    <?php foreach ($results as $result): ?>
                                        <tr>
                                            <td><?php echo $serial++; ?></td>
                                            <td><?php echo htmlspecialchars($result['exam_code']); ?></td>
                                            <td><?php echo htmlspecialchars($result['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($result['enrollment_number']); ?></td>
                                            <td><?php echo htmlspecialchars($result['total_question']); ?></td>
                                            <td><?php echo htmlspecialchars($result['maximum_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['user_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['total_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['percentage']); ?> &#37;</td>
                                            <td><button class="btn btn-info view-btn" data-toggle="modal" data-target="#resultModal" data-user_id="<?php echo $result['user_id']; ?>" data-exam_code="<?php echo $result['exam_code']; ?>">View <i class="bi bi-eye"></i></button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- this is show result for Rank , Toper student , Pass Students , list of fail Students, data in table -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="panel-title">Result for (Rank, Toper Student, Pass Students, Fail Students) Table</h3>
                    <div class="card">
                        <div class="card-body" style="margin: 10px 0;">
					        <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Pass Percentage<span class="text-danger">*</span></label>
                                    <div class="col-md-8 d-flex" style="width: 35%;">
                                        <input type="number" name="pass_percentage" id="pass_percentage" class="form-control" placeholder="Pass Percentage" required/>
                                        <button type="button" class="btn btn-primary btn-sm ml-2" id="ok_code_btn">OK</button>
                                    </div>
                                </div>
                            </div>
                            <div class="items_bar">
                                <div class="info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: black;">Total Student(s)</h5>
                                        <div class="ps-3">
                                            <span id="total_student">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: green;">Present Student(s) </h5>
                                        
                                        <div class="ps-3">
                                            <span id="_student">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: #1260f7;">Pass Student(s)</h5>
                                        <div class="ps-3">
                                            <span id="pass_student">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: #ec2984;">Fail Student(s)</h5>
                                        <div class="ps-3">
                                            <span id="fail_student">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div style="float: right; margin: 10px 10px;">
                                    <button id="export_for_rank_CSV" class="btn btn-primary">Donwload(CSV)</button>
                                </div>
                                <table id="result_rank_table" class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Exam Code</th>
                                            <th>Student Name</th>
                                            <th>Enrollment Number</th>
                                            <th>Total Question</th>
                                            <th>Percentage</th>
                                            <th>Rank</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $serial = 1; ?>
                                    <?php foreach ($results as $result): ?>
                                        <tr>
                                        <td><?php echo $serial++; ?></td>
                                            <td><?php echo htmlspecialchars($result['exam_code']); ?></td>
                                            <td><?php echo htmlspecialchars($result['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($result['enrollment_number']); ?></td>
                                            <td><?php echo htmlspecialchars($result['total_question']); ?></td>
                                            <td><?php echo htmlspecialchars($result['percentage']); ?> &#37;</td>
                                            <td class="rank"></td>
                                            <td class="status"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- this is result show for section wise table data  -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="panel-title">Result for Section Wise Table</h3>
                    <div class="card">
                        <div class="card-body" style="margin: 10px 0;">
                            <div class="table-responsive">
                                <div style="float: right; margin: 10px 10px;">
                                    <button id="export_for_section_CSV" class="btn btn-primary">Donwload(CSV)</button>
                                </div>
                                <table id="result_section_table" class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Exam Code</th>
                                            <th>Student Name</th>
                                            <th>Enrollment Number or Section Name</th>
                                            <th>Total Question</th>
                                            <th>Maximum Marks</th>
                                            <th>Marks</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $serial = 1; ?>
                                    <?php foreach ($results as $result): ?>
                                        <tr>
                                            <td><?php echo $serial++; ?></td>
                                            <td><?php echo htmlspecialchars($result['exam_code']); ?></td>
                                            <td><?php echo htmlspecialchars($result['user_name']); ?></td>
                                            <td><?php echo htmlspecialchars($result['enrollment_number']); ?></td>
                                            <td><?php echo htmlspecialchars($result['total_question']); ?></td>
                                            <td><?php echo htmlspecialchars($result['maximum_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['user_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['total_marks']); ?></td>
                                            <td><?php echo htmlspecialchars($result['percentage']); ?>&#37;</td>
                                            <td></td>
                                        </tr>
                                        <?php $ser = 1; ?>
                                        <?php 
                                            $sectionResults = SectionWiseData($result['user_id'], $result['exam_code']); 
                                            foreach ($sectionResults as $sectionResult): 
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td>-</td>
                                            <td><?php echo $ser ++; ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['section_name']); ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['total_questions']); ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['minimum_mark']); ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['user_mark']); ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['total_mark']); ?></td>
                                            <td><?php echo htmlspecialchars($sectionResult['percentagee']); ?>&#37;</td>
                                            <td></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- this is click this result view show Result for Section wise show in table -->
            <div id="resultModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Exam Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User Name:</th>
                                        <td id="modal_user_name"></td>
                                    </tr>
                                    <tr>
                                        <th>Enrollment Number:</th>
                                        <td id="modal_enrollment_number"></td>
                                    </tr>
                                    <tr>
                                        <th>Total Questions:</th>
                                        <td id="modal_total_question"></td>
                                    </tr>
                                    <tr>
                                        <th>Exam Duration:</th>
                                        <td id="modal_online_exam_duration"></td>
                                    </tr>
                                    <tr>
                                        <th>Exam Name:</th>
                                        <td id="modal_online_exam_title"></td>
                                    </tr>
                                    <tr>
                                        <th>Exam Code:</th>
                                        <td id="modal_exam_code"></td>
                                    </tr>
                                </thead>
                            </table>

                            <div id="section_results">
                                <!-- Section results will be injected here by JavaScript -->
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Total Marks:</th>
                                        <td id="modal_total_marks"></td>
                                    </tr>
                                    <tr>
                                        <th>Percentage:</th>
                                        <td id="modal_percentage"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<script>
    $(document).ready(function() {
        $('#exam_data').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": true,
            "pageLength": 10,
            "order": [],
            "ajax": {
                url: "ajax_action.php",
                method: "POST",
                data: { action: 'fetch', page: 'calculation_result_datas' }
            },
            "columnDefs": [
                {
                    "targets": [5],
                    "orderable": false,
                }
            ],
            "columns": [
                { "data": "online_exam_title" },
                { "data": "exam_code" },
                { "data": "total_question" },
                { "data": "online_exam_datetime" },
                { "data": "exam_result_publish_datetime" },
                { "data": "action", "render": function (data, type, row) {
                    if (row.result_processed === 'true') {
                        return '<a href="?exam_code=' + row.exam_code + '" class="btn btn-warning btn-sm view-result" data-code="' + row.exam_code + '">View Result</a>';
                    } else {
                        return '<a href="exam_process_result.php?code=' + row.exam_code + '" class="btn btn-dark btn-sm process-result" data-code="' + row.exam_code + '">Process Result</a>';
                    }
                }}
            ]
        });

        $('.view-btn').click(function() {
            var user_id = $(this).data('user_id');
            var exam_code = $(this).data('exam_code');

            console.log('User ID:', user_id);
            console.log('Exam Code:', exam_code);

            $.ajax({
                url: 'exam_resutl_fetch_user_data.php',
                method: 'POST',
                data: { user_id: user_id, exam_code: exam_code },
                dataType: 'json',
                success: function(data) {
                    console.log('Data received:', data);

                    if (data) {
                        $('#modal_user_name').text(data.user_name);
                        $('#modal_enrollment_number').text(data.enrollment_number);
                        $('#modal_total_question').text(data.total_question + ' Questions');
                        $('#modal_online_exam_duration').text(data.online_exam_duration  + ' Minutes');
                        $('#modal_online_exam_title').text(data.online_exam_title);
                        $('#modal_exam_code').text(data.exam_code);
                        $('#modal_total_marks').text(data.total_marks);
                        $('#modal_percentage').text(data.percentage + ' %');

                        var section_results_html = '<table class="table table-striped"><thead><tr><th>No.</th><th>Section Name</th><th>Total Questions</th><th>Total Right Answers</th><th>Total Wrong Answers</th><th>Maximum Marks</th><th>Negative Marks</th><th>Total Marks</th><th>Marks</th></tr></thead><tbody>';
                        var serial = 1;
                        data.sections.forEach(function(section) {
                            section_results_html += '<tr><td>' + serial++ + '</td><td>' + section.section_name + '</td><td>' + section.total_questions + '</td><td>' + section.total_right_answer + '</td><td>' + section.total_wrong_answer + '</td><td>' + section.minimum_mark + '</td><td>' + section.negative_mark + '</td><td>' + section.total_mark + '</td><td>' + section.user_mark + '</td></tr>';
                        });
                        section_results_html += '</tbody></table>';
                        $('#section_results').html(section_results_html);
                    } else {
                        $('#section_results').html('<p>No data found.</p>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching data:', textStatus, errorThrown);
                }
            });
        });

        $all = 10000;
        $('#result_table').DataTable({
            "pageLength": 10,
            
                "lengthMenu": [10, 25, 50, 100, $all],
                "pagingType": "simple_numbers",
                "dom": 'lfrtip',
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next"
                    }
                }
            });

        $('#exportCSV').click(function() 
        {
            var csv = [];
            var rows = $('#result_table').find('tr');

            var headings = [];
            $('#result_table th').each(function() {
                headings.push($(this).text());
            });
            csv.push(headings.join(','));

            rows.each(function(index, row) {
                var rowData = [];
                $(row).find('td').each(function(index, column) {
                    rowData.push($(column).text());
                });
                csv.push(rowData.join(','));
            });

            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement('a');
            var url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'exam_result.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }); 
    });

</script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#result_section_table').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100],
            "pagingType": "simple_numbers",
            "dom": 'lfrtip',
            "language": {
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                }
            }
        });

        // Export to CSV functionality
        $('#export_for_section_CSV').click(function() {
            var csv = [];
            var rows = $('#result_section_table').find('tr:has(td), tr:has(th)');

            // Get headings
            var headings = [];
            $('#result_section_table th').each(function() {
                headings.push($(this).text().trim());
            });
            csv.push(headings.join(','));

            // Get rows
            rows.each(function() {
                var rowData = [];
                $(this).find('td').each(function() {
                    rowData.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
                });
                csv.push(rowData.join(','));
            });

            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement('a');
            var url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'exam_section_result.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>

<script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#result_rank_table').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "pagingType": "simple_numbers",
                "dom": 'lfrtip',
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next"
                    }
                }
            });

            // Calculate Rank and Status based on Pass Percentage
            $('#ok_code_btn').click(function() {
                var passPercentage = parseFloat($('#pass_percentage').val());
                var table = $('#result_rank_table').DataTable();
                var data = table.rows().data();
                var studentData = [];

                for (var i = 0; i < data.length; i++) {
                    studentData.push({
                        row: data[i],
                        percentage: parseFloat(data[i][5].replace(' &#37;', ''))
                    });
                }

                studentData.sort(function(a, b) {
                    return b.percentage - a.percentage;
                });

                var passCount = 0;
                var failCount = 0;

                for (var i = 0; i < studentData.length; i++) {
                    var row = table.row(i).node();
                    var statusCell = $(row).find('.status');
                    var rankCell = $(row).find('.rank');

                    rankCell.text(i + 1);
                    if (studentData[i].percentage >= passPercentage) {
                        statusCell.text('Pass').css('color', '#1260f7');
                        passCount++;
                    } else {
                        statusCell.text('Fail').css('color', '#ec2984');
                        failCount++;
                    }
                }

                $('#total_student').text(studentData.length);
                $('#pass_student').text(passCount);
                $('#fail_student').text(failCount);
            });

            // Export to CSV
            $('#export_for_rank_CSV').click(function() {
                var csv = [];
                var rows = $('#result_rank_table').find('tr:has(td), tr:has(th)');

                // Get headings
                var headings = [];
                $('#result_rank_table th').each(function() {
                    headings.push($(this).text().trim());
                });
                csv.push(headings.join(','));

                // Get rows
                rows.each(function(index, row) {
                    var rowData = [];
                    $(row).find('td').each(function(index, column) {
                        rowData.push('"' + $(column).text().trim().replace(/"/g, '""') + '"');
                    });
                    csv.push(rowData.join(','));
                });

                var csvContent = csv.join('\n');
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                var link = document.createElement('a');
                var url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'exam_rank_wise_result.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
</script>
