<!--h-->
# HowToVideos

[![License](https://poser.pugx.org/laravel-enso/HowToVideos/license)](https://https://packagist.org/packages/laravel-enso/HowToVideos)
[![Total Downloads](https://poser.pugx.org/laravel-enso/HowToVideos/downloads)](https://packagist.org/packages/laravel-enso/HowToVideos)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/HowToVideos/version)](https://packagist.org/packages/laravel-enso/HowToVideos)
<!--/h-->

How-to video manager for Laravel Enso.

### Features

Allows you to add videos to your application, to show users how to perform a specific action, demonstrate a feature, 
present a process flow, etc. This is a complementary package to [Tutorial Manager](https://github.com/laravel-enso/TutorialManager).
 
 You can:
 * upload media clips from your computer
 * optionally add a better caption picture for each video
 * tag the clips and filter them using the tags 

### Installation

- install the package using composer `composer require laravel-enso/howtovideos`
- run the migrations `php artisan migrate`
- inside the `config/laravel-enso.php` configuration file, add the howToVideos path
```
'paths'  => [
    ..., 
    'howToVideos' => 'howToVideos', 
    ]
```  
- require/import the VueJS component 
```
Vue.component('howToVideo', require('./vendor/laravel-enso/components/howToVideos/HowToVideo.vue'));
```
- install the JS `vue-video-player video.js` dependencies with npm
 
### Notes

Even though the media files are filtered on upload using their mime-types, depending on the encoding and versions, 
some files might not work, as this is a limitation of the `video.js` library. Experiment and find what works for you.

### Publishes

- `php artisan vendor:publish --tag=howToVideos-storage` - the storage folder for the uploaded files

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h-->