/**
 * Created by Simon
 */

 $(document).ready(function() {

 	console.log("loaded");

 })

$('#checkLocationBased').on('mouseover', function (e) {
	alert("clicked");
})


$('#checkLocationBased').change(function(){

    if(this.checked){
        $('.locationDiv').show();
    } else {
        $('.locationDiv').hide();
    }
});

if($("#checkLocationBased").prop("checked")){
    $('.locationDiv').show();
}


