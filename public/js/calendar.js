$(function () {
  $('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    locale: 'fr',
    header: {
      left: 'today prev,next',
      center: 'title',
      right: 'timelineDay, month'
    },
    defaultView: 'timelineDay',
    dayClick: function(date, jsEvent, view) {
      $('#calendar').fullCalendar('changeView', 'timelineDay'),
      $('#calendar').fullCalendar('gotoDate', date);
    },
    businessHours: {
      dow: [ 1, 2, 3, 4, 5 ],
      start: '08:00',
      end: '18:00',
    },
    selectConstraint: {
      dow: [ 1, 2, 3, 4, 5 ],
      start: '08:00',
      end: '18:00',
    },
    selectable: true,
    validRange: {
      start: new Date(new Date().setHours(0,0,0,0)).getTime()
    },
    select: function(start, end, jsEvent, view, resource) {
      var overlap = false;
      var events = $('#calendar').fullCalendar('clientEvents');
      for (var i = 0; i < events.length; i++) {
        var event = events[i];
        if(event.resourceId == resource.id) {
          if((start >= event.start && start <= event.end) || (event.start >= start && event.start <= end)) {
            overlap = true;
          }
        }
      }
      if(overlap) {
        alert('Il existe déjà une attribution pour cet horaire.');
      } else {
        $("#booking-modal #booking-form #start").val(start.format());
        $("#booking-modal #booking-form #end").val(end.format());
        $("#booking-modal #booking-form #resource-id").val(resource.id);
        $("#booking-modal #resource-name").text(resource.title);
        $('#booking-modal').modal();
      }
    },
    eventClick: function(event, jsEvent, view) {
      $('#booking-delete-modal').modal();
      $("#booking-delete-modal #id").val(event.id);
    },
    resourceLabelText: 'Computer',
    resources: CONSTS.url.computer.getAll,
    events: {
      url: CONSTS.url.booking.getAll, 
    }
  });
});


