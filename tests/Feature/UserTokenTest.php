<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function usersCanAccessProtectedRoutesWithATokenEmailAndEvent()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $userToken = new UserToken;
        $userToken->fill(
            [
                'user_id' => $user->id,
                'event_id' => '1',
                'token_name' => "testname",
            ]
        );
        $token = $userToken->makeToken();
        $userToken->token = $token;
        $userToken->save();
        $response = $this->get('/subscribe/' . $token . '/' . $user->email . '/1');
        $response->assertOk();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function usersCanNotAccessProtectedRoutesWithATokenWithWrongEmail()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $userToken = new UserToken;
        $userToken->fill(
            [
                'user_id' => $user->id,
                'event_id' => '1',
                'token_name' => "testname",
            ]
        );
        $token = $userToken->makeToken();
        $userToken->token = $token;
        $userToken->save();
        $response = $this->get('/subscribe/' . $token . '/test@test.nl/1');
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function usersCanNotAccessProtectedRoutesWithATokenWithWrongEvent()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $userToken = new UserToken;
        $userToken->fill(
            [
                'user_id' => $user->id,
                'event_id' => '1',
                'token_name' => "testname",
            ]
        );
        $token = $userToken->makeToken();
        $userToken->token = $token;
        $userToken->save();
        $response = $this->get('/subscribe/' . $token . '/' . $user->email . '/2');
        $response->assertStatus(401);
    }
}