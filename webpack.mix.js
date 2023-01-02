const mix = require("laravel-mix");
let productionSourceMaps = false;

mix
  .js("resources/js/app.js", "assets/landing/js")
  .sass("resources/sass/preApp.scss", "assets/landing/css")
  .sass("resources/sass/app.scss", "assets/landing/css")
  .setPublicPath("./");
if (mix.inProduction()) {
  mix.version();
}
