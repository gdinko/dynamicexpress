<?php

namespace Gdinko\DynamicExpress\Facades;

use Illuminate\Support\Facades\Facade;

class DynamicExpress extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dynamicexpress';
    }
}
