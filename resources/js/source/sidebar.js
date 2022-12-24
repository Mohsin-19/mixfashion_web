(function ($) {

  $("body").on('click', '.has-treeview', function (e) {

    $("body").find('.has-treeview').removeClass('menu-open');

    $(this).addClass('menu-open');

  }).on('click', '.sidebar_collapse', function (e) {

    $("body").find('.main-sidebar').toggleClass('m-0');

  });


  $('[data-toggle="popover"]').popover({
    trigger: 'hover'
  });


})(jQuery);