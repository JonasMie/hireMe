/**
 * Created by jonas on 26.04.15.
 */

$('#checkCompanySignup').change(function(){
    if(this.checked){
        $('.companySetup').show();
    } else {
        $('.companySetup').hide();
    }
});

var selVal;