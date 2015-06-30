/**
 * Created by Simon
 */


$('#checkLocationBased').on('ifChecked', function(event){
     $('.locationDiv').show();
});

$("#checkLocationBased").on('ifUnchecked',function(event) {
	 $('.locationDiv').hide();
})


if($("#checkLocationBased").prop("checked")){
    $('.locationDiv').show();
}


