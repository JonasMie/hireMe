/**
 * Created by Simon
 */

var appData = [];


function dataHandler(file,app,direction) {

	 jQuery.get("/job/data-handler",{app:app,fileID:file,direction:direction} ,function (res) {
        $("#files").empty();
        $("#files").append(res);
     });  
}


