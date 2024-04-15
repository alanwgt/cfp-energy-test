<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * @param  string[]  $abilites
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null, array $abilites = []): self
    {
        Sanctum::actingAs($user, $abilites, $guard ?? 'sanctum');

        return $this;
    }
}
