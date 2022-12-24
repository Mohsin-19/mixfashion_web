$(function () {
    "use strict";

    function counter() {
        var i = 1;
        $(".counters").each(function(){
            $(this).html(i);
            i++;
        });
    }
    //drag and sorting
    $('#sortpage').dragsort({
        cursor:'move',
        dragEnd: function() {
            counter();
            console.log('Drag End');
            var data = $("form#sorting_form").serialize();
            $.ajax({
                url     : base_url+'Ajax/sortingPage',
                method  : 'get',
                dataType: 'json',
                data    : data,
                success:function(data){

            }
        });
        }
    });
});