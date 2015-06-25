/**
 * Created by Simon
 */

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