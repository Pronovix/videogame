/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application. See https://github.com/JeffreyWay/laravel-mix.
 |
 */
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Configuration
 |--------------------------------------------------------------------------
 */
mix
  .setPublicPath('assets')
  .disableNotifications()
  .options({
    processCssUrls: false
  });

/*
 |--------------------------------------------------------------------------
 | SASS
 |--------------------------------------------------------------------------
 */
mix.sass('src/sass/subtheme_videogame.style.scss', 'css');

/*
 |--------------------------------------------------------------------------
 | JS
 |--------------------------------------------------------------------------
 */
mix.js('src/js/subtheme_videogame.script.js', 'js');
