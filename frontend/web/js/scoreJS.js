/**
 * Created by Simon
 */

$("#scoreInput").focusout(function(e) {

score = $("#scoreInput").val();
app = $("#scoreInput").attr("name");
  jQuery.get("/application/change-score",{app:app,score:score} ,function (res) {
});   

})