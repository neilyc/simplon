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
      start: Date.now()
    },
    select: function(start, end, jsEvent, view, resource) {
      $("#booking-modal #booking-form #start").val(start.format());
      $("#booking-modal #booking-form #end").val(end.format());
      $("#booking-modal #booking-form #resource-id").val(resource.id);
      $("#booking-modal #resource-name").text(resource.title);
      $('#booking-modal').modal();
    },
    eventClick: function(event, jsEvent, view) {
      $.ajax({
        method: "DELETE",
        url: "/booking/"+event.id
      })
      .done(function( res ) {
        res = $.parseJSON(res);
        $("#calendar").fullCalendar('removeEvents', res.id);
      });
    },
    resourceLabelText: 'Computer',
    resources: '/computer/ajax',
    eventSources: [{
      url: '/booking', 
    }]
  });
});