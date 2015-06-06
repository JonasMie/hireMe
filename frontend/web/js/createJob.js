/**
 * Created by jonas on 26.04.15.
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