<?php

//Home_Panel.php

include('Admin_panel.php');
include '../mainfile.php';

?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="CSS\home_calendar.css"> 
    <!-- <script src="js\home_calender.js"></script> -->


<!-- ############################################################# -->
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Home Panel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Admin Panel</a></li>
          <li class="breadcrumb-item active">Home</li>
        </ol>
      </nav>
    </div>
      <!-- Recent Sales -->
  <section class="section">
    <div class="row">
      <div class="container">
          <div id="calendar"></div>
      </div>
      <!-- Start popup dialog box -->
      <div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalLabel">Add New Event</h5>
                      <button type="button" class="close" id="closeButton" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                            <label for="notification_msg">Add Event Message:</label>
                            <textarea class="form-control" id="event_name" name="event_name"  placeholder="Enter your event message....." required></textarea>
                        </div>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="event_start_date">Event start</label>
                                  <input type="date" name="event_start_date" id="event_start_date" class="form-control" placeholder="Event start date">
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <label for="event_end_date">Event end</label>
                                  <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary btn-sm" id ="save_event_button">Save Event</button>
                      <button type="button" class="btn btn-danger btn-sm" id="closeModalButton" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="event_details_modal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                    <button type="button" class="close" id="delete_event_but" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="event_details"></p>
                </div>
                <div class="modal-footer">
                    <p id="event_details"></p>
                    <button type="button" class="btn btn-warning btn-sm" id="edit_event_button">Edit</button>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">OK</button>
                    <button type="button" class="btn btn-danger btn-sm" id="delete_event_button">Delete</button>
                </div>
            </div>
        </div>
    </div>
  </section>
</main>


<script>
    $(document).ready(function() {
        display_events();

        $('#delete_event_button').click(function() {
            var eventId = $(this).data('event-id');
            delete_event(eventId);
        });

        $('#edit_event_button').click(function() {
            var event = $(this).data('event');
            $('#event_name').val(event.title);
            $('#event_start_date').val(moment(event.start).format('YYYY-MM-DD'));
            $('#event_end_date').val(moment(event.end).format('YYYY-MM-DD'));
            $('#event_id').val(event.event_id); // Set the hidden event ID input
            $('#event_details_modal').modal('hide'); // Close the event details modal
            $('#event_entry_modal').modal('show');
        });

        $('#save_event_button').click(function() {
            save_or_update_event();
        });
    });

    function display_events() {
        var events = [];
        $.ajax({
            url: 'calendar_event_handler.php?action=display',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    response.data.forEach(function(item) {
                        events.push({
                            event_id: item.event_id,
                            title: item.title,
                            start: item.start,
                            end: item.end,
                            color: item.color,
                            url: item.url
                        });
                    });

                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultView: 'month',
                        timeZone: 'local',
                        editable: true,
                        selectable: true,
                        selectHelper: true,
                        select: function(start, end) {
                            $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                            $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                            $('#event_id').val(''); // Clear the hidden event ID input for new events
                            $('#event_entry_modal').modal('show');
                        },
                        events: events,
                        eventRender: function(event, element) {
                            element.bind('click', function() {
                                $('#event_details').text(event.title);
                                $('#delete_event_button').data('event-id', event.event_id);
                                $('#edit_event_button').data('event', event);
                                $('#event_details_modal').modal('show');
                            });
                        }
                    });
                } else {
                    alert(response.msg);
                }
            },
            error: function(xhr, status) {
                alert('Error: ' + xhr.statusText);
            }
        });
    }

    function save_or_update_event() {
        var event_id = $("#event_id").val();
        var event_name = $("#event_name").val();
        var event_start_date = $("#event_start_date").val();
        var event_end_date = $("#event_end_date").val();

        if (event_name === "" || event_start_date === "" || event_end_date === "") {
            alert("Please enter all required details.");
            return false;
        }

        $.ajax({
            url: "calendar_event_handler.php?action=save_or_update",
            type: "POST",
            dataType: 'json',
            data: {
                event_id: event_id,
                event_name: event_name,
                event_start_date: event_start_date,
                event_end_date: event_end_date
            },
            success: function(response) {
                $('#event_entry_modal').modal('hide');
                if (response.status) {
                    alert(response.msg);
                    location.reload();
                } else {
                    alert(response.msg);
                }
            },
            error: function(xhr, status) {
                console.log('Ajax error = ' + xhr.statusText);
                alert('Error: ' + xhr.statusText);
            }
        });
    }

    function delete_event(event_id) {
        $.ajax({
            url: "calendar_event_handler.php?action=delete",
            type: "POST",
            dataType: 'json',
            data: {
                event_id: event_id
            },
            success: function(response) {
                $('#event_details_modal').modal('hide');
                if (response.status) {
                    alert(response.msg);
                    location.reload();
                } else {
                    alert(response.msg);
                }
            },
            error: function(xhr, status) {
                console.log('Ajax error = ' + xhr.statusText);
                alert('Error: ' + xhr.statusText);
            }
        });
    }
        $('#closeButton, #closeModalButton').click(function() {
              $('#event_entry_modal').modal('hide');
          }); 

        $('#delete_event_but').click(function() {
              $('#event_details_modal').modal('hide');
          });
    </script>

<!-- footer.php -->
<?php include('footer.php'); ?>