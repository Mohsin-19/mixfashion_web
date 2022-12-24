//check required on change
$(document).on('change', '#enable_status', function(e)    {
    checkRequried();
});
checkRequried();
function  checkRequried() {
    var this_value = $("#enable_status").val();
    if(Number(this_value)==1){
        $(".required_star").show();
    }else{
        $(".required_star").hide();
    }
}