<?php

namespace App\Models;

use App\Enum\AuthenticationMethod;
use App\Enum\Role;
use App\QueryBuilders\UserQueryBuilder;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $phone_number
 * @property string $date_of_birth
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property mixed|null $password
 * @property Role $role
 * @property AuthenticationMethod $authentication_method
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static UserQueryBuilder|User newModelQuery()
 * @method static UserQueryBuilder|User newQuery()
 * @method static UserQueryBuilder|User query()
 * @method static UserQueryBuilder|User whereAuthenticationMethod($value)
 * @method static UserQueryBuilder|User whereCreatedAt($value)
 * @method static UserQueryBuilder|User whereDateOfBirth($value)
 * @method static UserQueryBuilder|User whereEmail($value)
 * @method static UserQueryBuilder|User whereEmailVerifiedAt($value)
 * @method static UserQueryBuilder|User whereFirstName($value)
 * @method static UserQueryBuilder|User whereId($value)
 * @method static UserQueryBuilder|User whereIdentification(string $identification)
 * @method static UserQueryBuilder|User whereLastName($value)
 * @method static UserQueryBuilder|User wherePassword($value)
 * @method static UserQueryBuilder|User wherePhoneNumber($value)
 * @method static UserQueryBuilder|User whereRememberToken($value)
 * @method static UserQueryBuilder|User whereRole($value)
 * @method static UserQueryBuilder|User whereUpdatedAt($value)
 * @method static UserQueryBuilder|User whereUsername($value)
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'authentication_method' => AuthenticationMethod::class,
        'role' => Role::class,
    ];

    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function usesOtp(): bool
    {
        return $this->authentication_method === AuthenticationMethod::OTP;
    }
}
