<?php

namespace Silaswint\LaravelImpersonateGuest\App\Interfaces;

interface HasImpersonateGuest
{
    public function canImpersonateGuest(): bool;
}