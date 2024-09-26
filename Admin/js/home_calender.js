$(document).ready(function() {
    var $currentPopover = null;
    
    $(document).on('shown.bs.popover', function(ev) {
      var $target = $(ev.target);
      if ($currentPopover && ($currentPopover.get(0) != $target.get(0))) {
        $currentPopover.popover('toggle');
      }
      $currentPopover = $target;
    }).on('hidden.bs.popover', function(ev) {
      var $target = $(ev.target);
      if ($currentPopover && ($currentPopover.get(0) == $target.get(0))) {
        $currentPopover = null;
      }
    });
  
    function quicktmpl(template) {
      return new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};" +
        "with(obj){p.push('" +
        template.replace(/[\r\t\n]/g, " ").replace(/'(?=[^%]*%>)/g, "\t").split("'").join("\\'")
        .split("\t").join("'").replace(/<%=(.+?)%>/g, "',$1,'").split("<%").join("');").split("%>").join("p.push('") + "');}return p.join('');");
    }
  
    function updateEvents() {
      $('#holder').find('.calendar-event').each(function() {
        var $event = $(this);
        var $cell = $event.closest('.calendar-day, .time-td');
        var event = $event.data('event');
        var color = (event.color || '#D8D8D8');
        $event.css({
          'background': color,
          'border-color': color
        });
        if ($cell.is('.calendar-day')) {
          var $allDay = $cell.find('.all-day-events');
          if ($allDay.length === 0) {
            $allDay = $('<div class="all-day-events" />').appendTo($cell);
          }
          $event.appendTo($allDay);
        }
      });
    }
  
    // Function to display notifications
    function showNotification(message) {
      var $notification = $('<div class="alert alert-info notification"></div>');
      $notification.text(message);
      $('#notifications').append($notification);
      setTimeout(function() {
        $notification.fadeOut(function() {
          $(this).remove();
        });
      }, 3000);
    }
  
    // Function to add messages to the calendar
    function addMessage(date, message) {
      var $message = $('<div class="alert alert-success message"></div>');
      $message.text('Message for ' + date.toDateString() + ': ' + message);
      $('#messages').append($message);
    }
  
    // Sample data for the calendar
    var data = [
      {
        title: 'Sample Event',
        start: new Date(),
        end: new Date(),
        allDay: true,
        text: 'This is a sample event'
      }
    ];
  
    $('#holder').calendar({
      data: data,
      eventRender: function(event, element) {
        showNotification('Event "' + event.title + '" on ' + event.start.toDateString());
        addMessage(event.start, event.text);
      }
    });
  
    // Function to add a new event
    function addEvent(title, start, end, allDay, text) {
      var event = {
        title: title,
        start: start,
        end: end,
        allDay: allDay,
        text: text
      };
      data.push(event);
      $('#holder').calendar('refresh');
      showNotification('New event "' + title + '" added on ' + start.toDateString());
      addMessage(start, text);
    }
  
    // Example usage: Adding a new event
    addEvent('New Event', new Date(), new Date(), true, 'This is a new event');
  });
  