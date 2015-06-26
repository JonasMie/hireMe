/**
 * Created by Simon
 */

  $( "#saveCover" ).click(function(event) {
      event.preventDefault(); // Stop default behavior for submit button.
      var text = $("#covercreateform-text").val();
      if(text == "") {
      	text = "Nicht ausgefüllt";
      }
      var app = document.getElementById("hiddenApp").innerHTML;
     jQuery.get("/application/save-cover",{text:text,app:app} ,function (res) {
         alert(res);
     });   
  });


  $( "#sendIt" ).click(function(event) {
      event.preventDefault(); // Stop default behavior for submit button.
      var text = $("#covercreateform-text").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
      }
      var app = document.getElementById("hiddenApp").innerHTML;
     jQuery.get("/application/save-cover",{text:text,app:app} ,function (res) {
      window.location = '/job/send?id='+app;
     });   
  });


