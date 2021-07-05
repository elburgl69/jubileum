<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListSourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test #1
     */
    public function authorizedUsersCanCreateASourceList()
    {
        $response = $this->get('/source/create');

        $response->assertStatus(404);
    }
}
