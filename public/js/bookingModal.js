$(function () {
  $('#booking-form').submit(function (evt) {
    evt.preventDefault();
    $.ajax({
      method: "POST",
      url: "/booking/new",
      data: { 
        userId: $("#booking-modal #booking-form #userId").val(),
        resourceId: $("#booking-modal #booking-form #resource-id").val(),
        start: $("#booking-modal #booking-form #start").val(),
        end: $("#booking-modal #booking-form #end").val()
      }
    })
    .done(function( res ) {
      res = $.parseJSON(res);
      var event = {id: res.id, title: res.title, start:  res.start, end: res.end, resourceId: res.resourceId};
      $('#calendar').fullCalendar( 'renderEvent', event, true);
      $('#booking-modal').modal("hide");
    });
  });
});