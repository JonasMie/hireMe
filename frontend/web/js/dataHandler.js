/**
 * Created by Simon
 */
$(document).ready(function(){




});

/*
$('#addAttachement').on('click', function (e) {

  var app = document.getElementById("hiddenApp").innerHTML;
  var fileID = document.getElementById("hiddenFileID").innerHTML;
  jQuery.get("/job/add-Data",{app:app,fileID:fileID} ,function (res) {
         
     });   

});
*/

function testFunction() {
jQuery.get("/job/test",{} ,function (res) {

     });  

}

function dataHandler(file,app,direction) {

	 jQuery.get("/job/data-handler",{app:app,fileID:file,direction:direction} ,function (res) {
        $("#files").empty();
        $("#files").append(res);
     });  
}


