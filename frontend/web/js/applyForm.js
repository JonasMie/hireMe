/**
 * Created by Simon
 */
var appData = [];
var created = false;
var appID = "false";

function save() {

      var text = $("#coverText").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
      }
      var user = document.getElementById("user").innerHTML;
      var key = document.getElementById("key").innerHTML;
     
       jQuery.get("/job/create-app",{key:key,user:user,text:text,appData:appData,appID:appID} ,function (res) {
         if(jQuery.isNumeric(res)) {
            alert("Deine Bewerbung wurde gespeichert");
            appID = res;
         }
     });
}

  $( "#saveApplication" ).click(function(event) {

      event.preventDefault(); // Stop default behavior for submit button.
      save();

  });

  $( "#sendApp" ).click(function(event) {
      event.preventDefault(); // Stop default behavior for submit button.
      var text = $("#coverText").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
      }
      var user = document.getElementById("user").innerHTML;
      var key = document.getElementById("key").innerHTML;
     
       jQuery.get("/job/create-app",{key:key,user:user,text:text,appData:appData,appID:appID} ,function (res) {
         if(jQuery.isNumeric(res)) { 
           appID = res;
           jQuery.get("/job/send",{appID:appID} ,function (res) {
              alert(res);
              window.location = "/application";
          });
         }
     });
     
     

  });

function addFav() {

      var user = document.getElementById("user").innerHTML;
      var key = document.getElementById("key").innerHTML;

     jQuery.get("/job/save-favorit",{key:key,user:user} ,function (res) {
            alert(res);
            $("#addFavourite").empty();
            $("#addFavourite").append("Wurde hinzugefügt");
      });   


}



  function addData(fileID) {
    if($('#addAttachement'+fileID).hasClass("added")) {
        $('#addAttachement'+fileID).empty();
        $('#show_'+fileID).empty();
        $('#addAttachement'+fileID).append("Mitschicken");
        $('#addAttachement'+fileID).removeClass("added");
        appData = jQuery.grep(appData, function(value) {
        return value != fileID;
        });
    }
    else {
        $('#addAttachement'+fileID).empty();
        $('#addAttachement'+fileID).append("Einbehalten");
        $('#addAttachement'+fileID).addClass("added");
        $('#show_'+fileID).append("Angehängt");
        appData.push(fileID);
    }
          console.log(appData);
  }
