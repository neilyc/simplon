$(function () {
  $('#booking-form').submit(function (evt) {
    evt.preventDefault();
    $.ajax({
      method: "POST",
      url: CONSTS.url.booking.new,
      data: { 
        userId: $("#booking-modal #booking-form #userId").val(),
        resourceId: $("#booking-modal #booking-form #resource-id").val(),
        start: $("#booking-modal #booking-form #start").val(),
        end: $("#booking-modal #booking-form #end").val()
      }
    })
    .done(function( res ) {
      $('#calendar').fullCalendar( "refetchEvents" );
      $('#booking-modal').modal("hide");
    });
  });

  $('#booking-delete-modal .btn.btn-primary').on('click', function (e) {
    $.ajax({
      method: "DELETE",
      url: CONSTS.url.booking.delete+"/"+$("#booking-delete-modal #id").val()
    })
    .done(function( res ) {
      $('#calendar').fullCalendar( "refetchEvents" );
      $('#booking-delete-modal').modal("hide");
    });
  })
});