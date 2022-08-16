//for redirect counter
"use strict";
var timeInterval = 5;
setInterval(function(){
    timeInterval--;
    if(timeInterval<1){
        window.location.href=base_url;
    }else{
        $(".redirect_page_counter").html(timeInterval);
    }
}, 1000);