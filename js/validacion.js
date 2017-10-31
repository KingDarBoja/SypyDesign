$("#contact-form")
  // form validation failed
  .on("forminvalid.zf.abide", function(ev, frm) {
    // console.log("Form id "+ev.target.id+" is invalid");
  })
  // form validation passed, form will submit if submit event not returned false
  .on("formvalid.zf.abide", function(ev, frm) {


    // ajax post form
  })
  // to prevent form from submitting upon successful validation
  .on("submit", function(ev) {
    var name = $("input#name").val();
    var email = $("input#email").val();
    var subject = $("input#subject").val();
    var message = $("textarea#message").val();

    //Data for response
    var dataString = 'name=' + name + '&email=' + email + '&subject=' + subject + '&message=' + message;

    //Begin Ajax call
    var form = $("#contact-form");
    $.ajax({
      type: form.attr('method'),
      url: form.attr('action'),
      data: dataString,
      success: function() {
        $(".contactForm").html("<div id='thanks'></div>");
        $('#thanks').html("<h2>¡Gracias!</h2>")
          .append("<p> Estimado " + name + ", espera nuestra respuesta pronto. </p>")
          .hide()
          .fadeIn(1500);
      },
      error: function() {
        $(".contactForm").html("<div id='fallo'></div>");
        $('#fallo').html("<h2>Mal hecho</h2>")
          .append("<p> Estimado " + name + ", no se ha podido enviar su mensaje, por favor intente mas tarde. </p>")
          .hide()
          .fadeIn(1500);
      }
    }); //ajax call
    return false;
  });
