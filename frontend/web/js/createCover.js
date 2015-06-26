/**
 * Created by Simon
 */

  $( "#testSend" ).click(function(event) {
      event.preventDefault(); // Stop default behavior for submit button.
      var text = $("#covercreateform-text").val();
      if(text == "") {
      	alert("nichts");
      	text = "Nicht ausgefüllt";

      }
      var app = $('#hiddenApp').val();
      console.log(app);
     jQuery.get("/application/save-cover",{text:text,app:app} ,function (res) {

     });   
  });



