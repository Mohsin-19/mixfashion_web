<?php

if (!function_exists('instance')) {
  function instance()
  {
    $instance = &get_instance();
    return $instance;
  }
}


if (!function_exists('special_categories')) {
  function special_categories()
  {
    return instance()->Landing_model->specialCategories();
  }
}

if (!function_exists('all_categories')) {
  function all_categories()
  {
    return instance()->Landing_model->getCategories();
  }
}


if (!function_exists('search_page')) {
  function search_page()
  {
    return 1;
    return instance()->Landing_model->specialCategories();
  }
}

if (!function_exists('sidebar_categories')) {
  function sidebar_categories()
  {
    $all_categories = instance()->Landing_model->getSidebarCategories();
    $dataNew = [];
    $cat_id = 0;
    foreach ($all_categories as $key => $element) {

      if ($cat_id !== $element['id']) {
        $cat_id = $element['id'];
        foreach ($element as $key2 => $elem) {
          $dataNew[$cat_id][$key2] = $elem;
        }
      }
      $array = array_filter($element, function ($key) {
        return strpos($key, 'child_') === 0;
      }, ARRAY_FILTER_USE_KEY);

      $dataNew[$cat_id]['subcategories'][] = $array;
    }
    return $dataNew;
  }
}


if (!function_exists('all_special_categories')) {
  function all_special_categories()
  {
    return instance()->Landing_model->getSpecialCategories();
  }
}

if (!function_exists('get_pages')) {
  function get_pages()
  {
    return instance()->Landing_model->pages();
  }
}

if (!function_exists('responseJson')) {
  function responseJson($array)
  {
    return instance()->output
      ->set_content_type('application/json')
      ->set_output(json_encode($array));
  }
}


if (!function_exists('get_page_by_slug')) {
  function get_page_by_slug($slug)
  {
    return instance()->Common_model->getSinglePage($slug);
  }
}

if (!function_exists('social_login_msg')) {
  function social_login_msg()
  {
    $c_login_type_message = instance()->session->userdata('c_login_type_message');
    instance()->session->unset_userdata('c_login_type_message');
    return isset($c_login_type_message) && $c_login_type_message ? $c_login_type_message : '';
  }
}

if (!function_exists('floating')) {
  function floating($amount)
  {
    // method one
    // $fmt = new \NumberFormatter($locale = 'en_IN', NumberFormatter::DECIMAL);
    // return $fmt->format($amount);

    // method tho
    $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);

    return '৳ ' . $num;
    // return '৳ ' . number_format($amount, 0, '.', ',');
  }
}

if (!function_exists('youTube_id')) {

  function youTube_id($url)
  {
    $pattern = '%^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com(?:/embed/|/v/|/watch\?v=))([\w-]{10,12})%x';
    $pattern2 = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
    $result = preg_match($pattern2, $url, $match);
    return $result ? $match[1] : false;
  }
}
