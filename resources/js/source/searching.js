(function ($) {






  function UrlHistorySearchPushState(p_slug, p_name) {
    if (p_slug) {
      var slug = '/search/' + p_slug;
      document.title = p_name;
      history.pushState({
        page: 3
      }, p_name, slug);
    } else {
      document.title = 'Home';
      history.pushState({
        page: 1
      }, 'Home', '/');
    }
  }

  $(document).on('click', function () {
    var search = $('#search_landing').val();
    if (!search) {
      // $(document).find('.itemName').unmark();
      // $(document).find('.cat_products').unmark();
      // $(document).find('.subcat_products').unmark();
    }

  }).on("submit", ".header_search_form", function (event) {
    event.preventDefault();
    let keyword = $(this).find('input.form-control').val();
    if (keyword.length) {
      window.location.assign('/search/' + keyword);
    }
  });


  function marking_keywords(string) {
    $(document).find('.itemName').mark(string);
    // $(document).find('.cat_products').mark(string);
    // $(document).find('.subcat_products').mark(string);
  }

  $("body").on('keyup paste', '.search_landing', function () {
    $(".refreshSubcategory").remove(); // hide refresh page
    var searched_string = $(this).val().trim();

    var searching_page = $("#searching_page");
    var normal_page = $("#normal_page");

    $("html, body").animate({
      scrollTop: 0
    }, 1000);

    if (searched_string.length >= 1) {

      UrlHistorySearchPushState(searched_string, 'Searching...');

      searching_page.show();
      normal_page.hide();

      $.ajax({
        method: "POST",
        url: base_url + 'products-searching',
        data: {
          string: searched_string,
          offset: 0
        }
      }).done(function (data, status) {

        if (status === 'success') {
          $("#searching_product_load").html(data);
        }

        // marking_keywords(searched_string);

      }).fail(function (jqXHR, textStatus) {
        swal_alert_sad('Request Failed', textStatus);
      });

    } else {

      UrlHistorySearchPushState('', 'Searching...');


      searching_page.hide();
      normal_page.show();

    }

  }).on('click', '.search_trigger,.search_close', function (e) {

    $('.mobile_search_landing').val('');
    $('.search_landing').val('');
    $('.product_search_form2').toggleClass('d-none');

  }).on('keyup paste', '.mobile_search_landing', function (e) {

    $('.search_landing').val($(this).val()).trigger('keyup');

  });


  let ready = true; //Assign the flag here
  let counter = 0;


  $(window).scroll(function () {
    if (ready && isScrolledIntoView(".autoScrollEventHandler")) {
      ready = false;
      let container = $(".products_container");
      let searchContainer = $(".search_products_container");
      let search_options = $(".search_options").text();
      let options = $(".page_options").text();
      let search_landing = $(".search_landing").val();
      if (options && search_landing == '') {
        options = options ? JSON.parse(options) : {};
      } else {
        container = searchContainer;
        options = search_options ? JSON.parse(search_options) : {};
      }

      // console.log(options);

      let page = options.hasOwnProperty('page') ? options.page : '';
      let cat_id = options.hasOwnProperty('cat_id') ? options.cat_id : 0;
      let parent_id = options.hasOwnProperty('parent_id') ? options.parent_id : '';

      $('.autoScrollEventHandler').remove();

      let offset = Number(container.find(".itemWrapper").length);

      let $noMore = '<div class="loading_info" style="width: 100%;text-align: center;margin: 40px 0;"><span style="color:#666">...</span></div>';

      if (page === "search" && offset) {
        let searched_string = $(".search_landing").val().trim();
        console.log(searched_string);
        console.log(offset);
        if (searched_string) {
          $.ajax({
            method: "POST",
            url: base_url + 'products-searching',
            data: {
              string: searched_string,
              offset: offset,
              scroll: true
            },
            beforeSend: function () {
              container.append($noMore);
            },
            success: function (data) {
              if (data.status) {
                container.append(data.products);
                ready = true; //Reset the flag here
              }
              container.find('.loading_info').remove();
            }
          });
        }
        // console.log('search');
      } else if (page === "products" && offset) {
        $.ajax({
          method: "POST",
          url: base_url + "get-sub-category-products",
          data: {
            id: cat_id,
            parent_id: parent_id,
            offset: offset
          },
          beforeSend: function () {
            container.append($noMore);
          },
          success: function (data) {
            if (data.status) {
              container.append(data.products);
              ready = true; //Reset the flag here
            }
            container.find('.loading_info').remove();
          }
        });
      }
    }

    if ($(window).scrollTop() < 200) {
      ready = true;
    }

  });


  function isScrolledIntoView(elem) {
    let element = $(elem);
    if (element.length) {
      var docViewTop = $(window).scrollTop();
      var docViewBottom = docViewTop + $(window).height();
      var elemTop = element.offset().top;
      var elemBottom = elemTop + element.height();
      return elemBottom <= docViewBottom && elemTop >= docViewTop;
    }
  }


})(jQuery)