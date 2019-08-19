<?php

namespace Weidner\Goutte;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\BrowserKit\CookieJar;

class GoutteServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the path of the configuration file shipping with the package.
     *
     * @return string
     */
    public function getConfigPath()
    {
        return dirname(__DIR__) . '/config/goutte.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig($this->getConfigPath());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerServices();
        $this->registerAliases();
    }

    /**
     * Register a path to be published by the publish command.
     *
     * @param string $path
     * @param string $group
     * @return void
     */
    protected function publishConfig($path, $group = 'config')
    {
        $this->publishes([$path => config_path('goutte.php')], $group);
    }

    /**
     * Register the default configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'goutte');
    }

    /**
     * Register the Goutte instance.
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->bind(History::class);
        $this->app->bind(CookieJar::class);

        $this->app->singleton('goutte.client', function ($app) {
            $config = $app->make('config');

            $client = new GuzzleClient([
                'base_url' => $config->get('goutte.base_url', null),
                'defaults' => $config->get('goutte.client', [])
            ]);

            return $client;
        });

        $this->app->singleton('goutte', function ($app) {
            $config = $app->make('config');

            $goutte = new GoutteClient(
                $config->get('goutte.server', []),
                $app->make(History::class),
                $app->make(CookieJar::class)
            );

            $goutte->setClient($app->make('goutte.client'));

            return $goutte;
        });
    }

    /**
     * Register class aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        $this->app->alias('goutte', GoutteClient::class);
        $this->app->alias('goutte.client', GuzzleClient::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'goutte',
            'goutte.client',
        ];
    }
}
