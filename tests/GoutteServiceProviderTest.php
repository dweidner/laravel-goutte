<?php

namespace Weidner\Goutte;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;

class GoutteServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function has_registered_services()
    {
        $this->assertTrue($this->app->bound('goutte'));
        $this->assertTrue($this->app->bound('goutte.client'));
    }

    /**
     * @test
     */
    public function has_registered_aliases()
    {
        $this->assertTrue($this->app->isAlias(GoutteClient::class));
        $this->assertEquals('goutte', $this->app->getAlias(GoutteClient::class));

        $this->assertTrue($this->app->isAlias(GuzzleClient::class));
        $this->assertEquals('goutte.client', $this->app->getAlias(GuzzleClient::class));
    }

    /**
     * @test
     */
    public function has_registered_package_config()
    {
        $config = $this->app->make('config');

        $this->assertEquals($config->get('goutte.client'), [
            'allow_redirects' => false,
            'cookies' => true,
        ]);
    }
}
