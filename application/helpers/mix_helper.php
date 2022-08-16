<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('mix')) {
  /**
   * @param $path
   * @param string $manifestDirectory
   * @return string
   * @throws Exception
   */
  function mix($path, $manifestDirectory = '')
  {
    static $manifest;
    $publicFolder = '';
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    $publicPath = $rootPath . $publicFolder;
    if ($manifestDirectory && !starts_with($manifestDirectory, '/')) {
      $manifestDirectory = "/{$manifestDirectory}";
    }
    if (!$manifest) {
      if (!file_exists($manifestPath = ($rootPath . $manifestDirectory . '/mix-manifest.json'))) {
        throw new Exception('The Mix manifest does not exist.');
      }
      $manifest = json_decode(file_get_contents($manifestPath), true);
    }
    if (!starts_with($path, '/')) {
      $path = "/{$path}";
    }
    $path = $publicFolder . $path;
    if (!array_key_exists($path, $manifest)) {
      throw new Exception(
        "Unable to locate Mix file: {$path}. Please check your " .
          'webpack.mix.js output paths and try again.'
      );
    }
    return file_exists($publicPath . ($manifestDirectory . '/hot'))
      ? "http://localhost:8080{$manifest[$path]}"
      : $manifestDirectory . $manifest[$path];
  }
}


function starts_with($haystack, $needle)
{
  $length = strlen($needle);
  return substr($haystack, 0, $length) === $needle;
}

function ends_with($haystack, $needle)
{
  $length = strlen($needle);
  if (!$length) {
    return true;
  }
  return substr($haystack, -$length) === $needle;
}


if (!function_exists('show_field_error')) {

  function show_field_error($field)
  {
    $response = '';
    if (form_error($field)) {
      $response = '<div class="alert alert-error txt-uh-21">';
      $response .= '<p>' . form_error($field) . '</p>';
      $response .= '</div>';
    }
    return $response;
  }
}
