# Laravel Facade for Goutte

This repository implements a simple [ServiceProvider](https://laravel.com/docs/master/providers) that makes a singleton instance of the Goutte client easily accessible via a [Facade](https://laravel.com/docs/master/facades) in [Laravel](http://laravel.com). See [@FriendsOfPHP/Goutte](https://github.com/FriendsOfPHP/Goutte) for more information about the PHP web scraper and its interfaces.

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
        "php": "^7.2",
        "laravel/framework": "^8",
        "weidner/goutte": "^2",
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
        Weidner\Goutte\GoutteServiceProvider::class, // [1] This will register the Package in the laravel echo system

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

        'Goutte' => Weidner\Goutte\GoutteFacade::class, // [2] It will register as an alias for the Goutte facade
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

*TIP:* You can use the package with [Lumen](https://lumen.laravel.com/) as well. Register the `GoutteServiceProvider` in `bootstrap/app.php` and provide the missing path to your configuration directory in your `AppServiceProvider` (ref [\#34](https://github.com/dweidner/laravel-goutte/issues/34/)).

## Configuration

You can customize the default request options to apply to each request of the client. Copy the default configuration to your application directory first:

```sh
php artisan vendor:publish --provider="Weidner\Goutte\GoutteServiceProvider"
```

Open the created file in the `config/goutte.php` and customize the configuration options to your liking.

```php
<?php

return [
    'client' => [
        'max_redirects' => 0,
    ],
];
```

Have a look into the [Symfony Http Client Documentation](https://symfony.com/doc/current/http_client.html) for a full list of available options.

## Version Constraint

| Release            | Supported Versions |
|--------------------|--------------------|
| Laravel Goutte 2.2 | Laravel 8/9        |
| Laravel Goutte 2.0 | Laravel 8          |
| Laravel Goutte 1.6 | Laravel 5/6/7      |
