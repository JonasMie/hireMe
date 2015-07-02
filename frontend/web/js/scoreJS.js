/**
 * Created by Simon
 */

$(".scoreInput").focusout(function(e) {

var thisInput = $(this);
var id = $(this).attr("id");
var score = $("#"+id).val();
var app = $("#"+id).attr("name");

  jQuery.get("/application/change-score",{app:app,score:score} ,function (res) {
	  $(thisInput).css("border","#5CCA88 2px solid");
});   

})