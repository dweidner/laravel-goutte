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

        $this->assertInstanceOf(GoutteClient::class, $this->app->make('goutte'));
        $this->assertInstanceOf(GuzzleClient::class, $this->app->make('goutte.client'));
    }

    /**
     * @test
     */
    public function has_registered_aliases()
    {
        $this->assertTrue($this->app->isAlias(GoutteClient::class));
        $this->assertEquals('goutte', $this->app->getAlias(GoutteClient::class));
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

    /**
     * @test
     */
    public function does_provide_singleton_instance ()
    {
        $this->assertSame($this->app->make('goutte'), $this->app->make('goutte'));
        $this->assertSame($this->app->make('goutte.client'), $this->app->make('goutte.client'));
    }

    /**
     * @test
     */
    public function does_not_remap_guzzle_client_to_custom_singleton() 
    {
        $a = $this->app->make(GuzzleClient::class);
        $b = $this->app->make(GuzzleClient::class);

        $this->assertNotSame($a, $b);
    }
}
