<?php

namespace Tests\Feature;

use App\Http\Resources\UserDetailedResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_sign_in_by_email(): void
    {
        $email = fake()->email;

        /** @var User $user */
        $user = User::factory()->create([
            'email' => $email,
        ]);

        $this->postJson(route('api.v1.auth.sign-in'), [
            'identification' => $email,
            'password' => 'password',
        ])->assertSuccessful()->assertJson(['data' => UserDetailedResource::make($user)->jsonSerialize()]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_sign_in_by_username(): void
    {
        $username = fake()->userName;
        $password = fake()->password;

        /** @var User $user */
        $user = User::factory()->password($password)->create([
            'username' => $username,
        ]);

        $this->postJson(route('api.v1.auth.sign-in'), [
            'identification' => $username,
            'password' => $password,
        ])->assertSuccessful()->assertJson(['data' => UserDetailedResource::make($user)->jsonSerialize()]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_check_if_is_authenticated(): void
    {
        $this->actingAsUser();

        $this->getJson(route('api.v1.auth.check'))
            ->assertSuccessful()
            ->assertJson(['data' => UserDetailedResource::make(auth()->user())->jsonSerialize()]);
    }

    public function test_user_cannot_sign_in_with_invalid_credentials(): void
    {
        $this->postJson(route('api.v1.auth.sign-in'), [
            'identification' => 'foo@bar.com',
            'password' => 'password',
        ])->assertUnauthorized();
    }

    public function test_user_will_be_throttled_after_two_failed_sign_in_attempts(): void
    {
        $this->markTestIncomplete();
        //        $this->postJson(route('api.v1.auth.sign-in'), [
        //            'email' => 'invalid@password.com',
        //            'password' => 'invalid-password',
        //        ])->assertUnauthorized();
        //
        //        $this->postJson(route('api.v1.auth.sign-in'), [
        //            'email' => 'invalid@password.com',
        //            'password' => 'invalid-password',
        //        ])->assertTooManyRequests();
    }

    public function test_unauthenticated_user_cannot_sign_out(): void
    {
        $this->postJson(route('api.v1.auth.sign-out'))
            ->assertUnauthorized();
    }

    public function test_user_can_check_authentication_method(): void
    {
        $email = fake()->email;
        User::factory()->create([
            'email' => $email,
            'authentication_method' => 'password',
        ]);

        $this->postJson(route('api.v1.auth.authentication-method', ['identification' => $email]))
            ->assertJson([
                'authentication_method' => 'password',
            ]);
    }

    public function test_user_can_check_authentication_method_for_non_existent_user(): void
    {
        $this->postJson(route('api.v1.auth.authentication-method', ['identification' => fake()->email]))
            ->assertJson([
                'authentication_method' => 'password',
            ]);
    }

    public function test_authentication_method_should_return_bad_request_for_bad_email(): void
    {
        $this->postJson(route('api.v1.auth.authentication-method', ['email' => 'invalid-email']))
            ->assertBadRequest();
    }

    public function test_user_can_sign_in_with_otp(): void
    {
        $this->markTestIncomplete('login with OTP is not implemented yet');
    }

    public function test_user_can_register_with_password_and_be_automatically_signed_in_as_normal_user(): void
    {
        $this->postJson(route('api.v1.auth.sign-up'), $this->generateUserData())->assertSuccessful();

        $this->assertAuthenticated('web');
    }
}
