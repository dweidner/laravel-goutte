# Laravel 5 Facade for Goutte

This repository implements a simple [ServiceProvider](https://laravel.com/docs/master/providers) that makes a singleton instance of the Goutte client easily accessible via a [Facade](https://laravel.com/docs/master/facades) in [Laravel 5](http://laravel.com). See [@FriendsOfPHP/Goutte](https://github.com/FriendsOfPHP/Goutte) for more information about the PHP web scraper and its interfaces.

## Installation using [Composer](https://getcomposer.org/)

In your terminal application move to the root directory of your laravel project using the `cd` command and require the project as a dependency using composer.

```sh
$ cd ~/Sites/laravel-example-project
$ composer require weidner/goutte
```

This will add the following lines to your `composer.json` and download the project and its dependencies to your projects `./vendor` directory:

```json
// ./composer.json
{
    "name": "weidner/laravel-goutte-test",
    "description": "A dummy project used to test the Laravel Goutte Facade.",

    // ...

    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*",
        "weidner/goutte": "1.0.*",
        // ...
    },

    //...
}
```


## Usage

In order to use the static interface we first have to customize the application configuration to tell the system where it can find the new service. Open the file `config/app.php` in the editor of your choice and add the following lines (`[1]`, `[2]`):

```php
// config/app.php

return [

    // ...

    'providers' => [

        // ...

        /*
         * Package Service Providers...
         */
        Weidner\Goutte\GoutteServiceProvider::class, // [1]

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    // ...

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,

        // ...

        'Goutte' => Weidner\Goutte\GoutteFacade::class, // [2]
        'Hash' => Illuminate\Support\Facades\Hash::class,

        // ...
    ],

];

```

Now you should be able to use the facade within your application. Laravel will autoload the corresponding classes once you use the registered alias.

```php
// routes/web.php

Route::get('/', function() {
    $crawler = Goutte::request('GET', 'https://duckduckgo.com/html/?q=Laravel');
    $crawler->filter('.result__title .result__a')->each(function ($node) {
      dump($node->text());
    });
    return view('welcome');
});
```

*TIP:* If you retrieve a "Class 'Goutte' not found"-Exception try to update the autoloader by running `composer dump-autoload` in your project root.
