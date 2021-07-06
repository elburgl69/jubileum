<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\CssSelector\Parser\Token;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test #7
     */
    public function usersCanAccessProtectedRoutesWithATokenEmailAndEvent()
    {
        $this->withoutExceptionHandling();
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
     * @test #7
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
     * @test #7
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

    /**
     * @test #7
     */
    public function usersCanNotAccessProtectedRoutesWithAnInvalidToken()
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
        $token = str_replace("A", "a", $token);
        $response = $this->get('/subscribe/' . $token . '/' . $user->email . '/2');
        $response->assertStatus(401);
    }
}