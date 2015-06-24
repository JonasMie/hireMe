/**
 * Created by jonas on 26.04.15 but made awesome by Marco on 19.6.15. ;)
 */

$('#checkCompanySignup').on('ifChecked', function(event){
    $('.companySetup').show();
});

// if validation in company signup fails, the page is rerendered and the checkbox remains checked, but the inputs are not displayed
// this resolves the issue
// dont know, if all browsers behave like this (checkbox remains checked after submit), so i added another fallback
// php checks if errors are set in signup-model. if there are errors, it forces the company-signup div to be shown
// (see \frontend\models\login.php)
//
// --jonas
if($('#checkCompanySignup').prop('checked')){
    $('.companySetup').show();
}

$('#checkCompanySignup').on('ifUnchecked', function(event){
    $('.companySetup').hide();
});
