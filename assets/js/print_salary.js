//print salary
"use strict";
$(document).on('click', '.printNow', function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    let newWindow = open("printSalary/"+id, 'Print Salary', 'width=1600,height=550');
    newWindow.focus();
    newWindow.onload = function() {
        newWindow.document.body.insertAdjacentHTML('afterbegin');
    };
});