//check required function
"use strict";
$(document).on('change', '#enable_status', function(e){
    checkRequried();
});
//call check required function
checkRequried();
function  checkRequried() {
    var this_value = $("#enable_status").val();
    if(Number(this_value)==1){
        $(".required_star").show();
    }else{
        $(".required_star").hide();
    }
}