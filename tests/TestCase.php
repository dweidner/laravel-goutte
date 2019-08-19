<?php

namespace Weidner\Goutte;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            GoutteServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Goutte' => GoutteFacade::class
        ];
    }
}
