<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_can_login(): void
    {
        $email = fake()->email;
        $password = fake()->password;

        /** @var User $user */
        $user = User::factory()->password($password)->create([
            'email' => $email,
        ]);

        $this->postJson(route('auth.session.store'), [
            'email' => $email,
            'password' => $password,
        ])->assertSuccessful();

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $this->postJson(route('auth.session.store'), [
            'email' => 'foo@bar.com',
            'password' => 'password',
        ])->assertUnauthorized();
    }

    public function test_user_will_be_throttled_after_two_failed_login_attempts(): void
    {
        $this->postJson(route('auth.session.store'), [
            'email' => 'invalid@password.com',
            'password' => 'invalid-password',
        ])->assertUnauthorized();

        $this->postJson(route('auth.session.store'), [
            'email' => 'invalid@password.com',
            'password' => 'invalid-password',
        ])->assertTooManyRequests();
    }

    public function test_user_can_logout(): void
    {
        $this->actingAs(User::factory()->create())
            ->deleteJson(route('auth.session.destroy'))
            ->assertSuccessful();
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $this->deleteJson(route('auth.session.destroy'))
            ->assertUnauthorized();
    }

    public function test_user_can_check_authentication_method(): void
    {
        $email = fake()->email;
        User::factory()->create([
            'email' => $email,
            'authentication_method' => 'password',
        ]);

        $this->postJson(route('auth.authentication-method', ['email' => $email]))
            ->assertJson([
                'authentication_method' => 'password',
            ]);
    }

    public function test_user_can_check_authentication_method_for_non_existent_user(): void
    {
        $email = fake()->email;

        $this->postJson(route('auth.authentication-method', ['email' => $email]))
            ->assertJson([
                'authentication_method' => 'password',
            ]);
    }

    public function test_authentication_method_should_return_bad_request_for_bad_email(): void
    {
        $this->postJson(route('auth.authentication-method', ['email' => 'invalid-email']))
            ->assertBadRequest();
    }

    public function test_user_can_login_with_otp(): void
    {
        $this->markTestIncomplete('login with OTP is not implemented yet');
    }

    public function test_user_can_register_with_password_and_be_automatically_signed_in_as_normal_user(): void
    {
        $this->postJson(route('auth.store'), [
            'email' => fake()->email,
            'password' => fake()->password(8),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone_number' => fake()->phoneNumber,
            'date_of_birth' => fake()->date,
            'username' => fake()->userName,
        ])->assertSuccessful();

        $this->assertAuthenticated();
    }
}
