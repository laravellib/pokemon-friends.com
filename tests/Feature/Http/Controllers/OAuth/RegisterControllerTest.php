<?php namespace obsession\Http\Controllers\Ajax;

use Tests\TestCase;
use Tests\OAuthTestCaseTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use obsession\Domain\Users\Users\User;

class RegisterControllerTest extends TestCase
{

    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testRegistration()
    {
        $user = factory(User::class)->states(User::ROLE_CUSTOMER)->make();

        $this
            ->post('/api/oauth/register', $user->toArray() + [
                    'password' => $this->getDefaultPassword(),
                    'password_confirmation' => $this->getDefaultPassword()
                ]
            )
            ->assertStatus(201)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_at']);
    }
}
