/**
 * Created by Simon
 */
var appData = [];
var created = false;
var appID = "false";
var controller 

function save() {

      controller = document.getElementById("controller").innerHTML;
      var text = $("#coverText").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
      }

      if(controller == "intern") {
        var jobID = document.getElementById("jobID").innerHTML;
        console.log(jobID);
        jQuery.get("/job/create-app",{intern:'true',text:text,appData:appData,appID:appID,job:jobID} ,function (res) {
         if(jQuery.isNumeric(res)) {
			$("#saveApplication").remove();
            $(".save").append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Bewerbung gespeichert");
			window.scrollTo(0, 0);
			$('.saveAlert').css('display','block');
			appID = res;
         }
     });
      } 
      else {
      var key = document.getElementById("key").innerHTML;
      var user = document.getElementById("user").innerHTML;

       jQuery.get("/job/create-app",{key:key,user:user,text:text,appData:appData,appID:appID} ,function (res) {
         if(jQuery.isNumeric(res)) {
			$("#saveApplication").remove();
            $(".save").append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Bewerbung gespeichert");
			window.scrollTo(0, 0);
			$('.saveAlert').css('display','block');
            appID = res;
         }
     });
     }
}

  $( "#saveApplication" ).click(function(event) {

      event.preventDefault(); // Stop default behavior for submit button.
      save();

  });

  $( "#sendApp" ).click(function(event) {


      event.preventDefault(); // Stop default behavior for submit button.
      controller = document.getElementById("controller").innerHTML;
      var text = $("#coverText").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
      }

      if(controller == "intern") {
        var jobID = document.getElementById("jobID").innerHTML;
        console.log(jobID);
        jQuery.get("/job/create-app",{intern:'true',text:text,appData:appData,appID:appID,job:jobID} ,function (res) {
         if(jQuery.isNumeric(res)) {
            appID = res;
            jQuery.get("/job/send",{appID:appID} ,function (res) {
              $("#sendApp").remove();
			  $(".send").append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Bewerbung verschickt");
			  window.scrollTo(0, 0);
			  $('.sendAlert').css('display','block');
              /*window.location = "/application";*/
          });
         }
     });
      } 
      else {
      var key = document.getElementById("key").innerHTML;
      var user = document.getElementById("user").innerHTML;

       jQuery.get("/job/create-app",{key:key,user:user,text:text,appData:appData,appID:appID} ,function (res) {
         if(jQuery.isNumeric(res)) {
            appID = res;
            jQuery.get("/job/send",{appID:appID} ,function (res) {
              $("#sendApp").remove();
			  $(".send").append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Bewerbung verschickt");
			  window.scrollTo(0, 0);
			  $('.sendAlert').css('display','block');
              /*window.location = "/application";*/
          });
         }
     });
     }

  });

function addFav() {

      var user = document.getElementById("user").innerHTML;
      var key = document.getElementById("key").innerHTML;

     jQuery.get("/job/save-favorit",{key:key,user:user} ,function (res) {
            $("#addFavourite").remove();
            $(".saveFav").append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Die Stellenanzeige wurde als Favorit gespeichert");
      });   


}

$("#saveCover").click(function(event) {

    var appID = document.getElementById("hiddenApp").innerHTML;
     var text = $("#covercreateform-text").val();
      if(text == "") {
        text = "Nicht ausgefüllt";
    }

    jQuery.get("/application/save-cover",{app:appID,text:text} ,function (res) {
            alert(res);
      });   

});


  function addData(fileID) {
    if($('#addAttachement'+fileID).hasClass("added")) {
        $('#addAttachement'+fileID).empty();
        $('#show_'+fileID).empty();
        $('#addAttachement'+fileID).append("<span class='glyphicon glyphicon-floppy-open'></span>&nbsp;&nbsp;Anhängen");
        $('#addAttachement'+fileID).removeClass("added");
		$('#addAttachement'+fileID).removeClass("btn-default");
		$('#addAttachement'+fileID).addClass("btn btn-success");
        appData = jQuery.grep(appData, function(value) {
        return value != fileID;
        });
    }
    else {
        $('#addAttachement'+fileID).empty();
        $('#addAttachement'+fileID).append("<span class='glyphicon glyphicon-floppy-save'></span>&nbsp;&nbsp;Entfernen");
        $('#addAttachement'+fileID).addClass("added");
		$('#addAttachement'+fileID).addClass("btn btn-default");
		$('#addAttachement'+fileID).removeClass("btn-success");
        $('#show_'+fileID).append("<span class='highlight glyphicon glyphicon-ok'></span>&nbsp;Angehängt");
        appData.push(fileID);
    }
          console.log(appData);
  }
