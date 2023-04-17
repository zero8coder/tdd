<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    protected function getAdminUser()
    {
        return User::factory()->create(['name' => '浩忠']);
    }

    protected  function signInAdmin()
    {
        $this->actingAs($this->getAdminUser());
        return $this;
    }
}
