<?php

namespace bebo925\Approvals\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \bebo925\Approvals\Approvals
 */
class Approvals extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \bebo925\Approvals\Approvals::class;
    }
}
