<?php

namespace Weidner\Goutte;

use Goutte\Client as GoutteClient;

class GoutteServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function has_registered_services()
    {
        $this->assertTrue($this->app->bound('goutte'));

        $this->assertInstanceOf(GoutteClient::class, $this->app->make('goutte'));
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
            'max_redirects' => 0
        ]);
    }

    /**
     * @test
     */
    public function does_provide_singleton_instance ()
    {
        $this->assertSame($this->app->make('goutte'), $this->app->make('goutte'));
    }

}
