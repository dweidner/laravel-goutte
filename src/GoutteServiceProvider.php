<?php namespace Weidner\Goutte;

use Weidner\Goutte\Goutte;
use Illuminate\Support\ServiceProvider;

class GoutteServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = true;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerGoutte();

    $this->app->alias('goutte', 'Goutte\Client');
  }

  /**
   * Register the Goutte instance.
   *
   * @return void
   */
  protected function registerGoutte()
  {
    $this->app->singleton('goutte', function($app)
    {
      return new \Goutte\Client();
    });
  }


  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [ 'goutte' ];
  }

}
