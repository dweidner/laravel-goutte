<?php

namespace Weidner\Goutte;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Weidner\Goutte\Goutte
 */
class GoutteFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'goutte';
    }
}
