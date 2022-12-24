require('waypoints/lib/jquery.waypoints');


$(function () {

  function ckScrollInit(items, trigger) {
    items.each(function () {
      var ckElement = $(this),
        AnimationClass = ckElement.attr('data-animation'),
        AnimationDelay = ckElement.attr('data-animation-delay');

      ckElement.css({
        '-webkit-animation-delay': AnimationDelay,
        '-moz-animation-delay': AnimationDelay,
        'animation-delay': AnimationDelay,
        opacity: 0
      });

      var ckTrigger = (trigger) ? trigger : ckElement;

      ckTrigger.waypoint(function () {
        ckElement.addClass("animated").css("opacity", "1");
        ckElement.addClass('animated').addClass(AnimationClass);
      }, {
        triggerOnce: true,
        offset: '90%',
      });
    });
  }

  ckScrollInit($('.animation'));
  ckScrollInit($('.staggered-animation'), $('.staggered-animation-wrap'));



  // $("body").on('click', '#pr_item_gallery .item', function(){

  //   $(this).closest(".slick-track").find('a.product_gallery_item').removeClass('active');
  //   $(this).find("a.product_gallery_item").addClass('active');
  // });









});