<?php

namespace App\Models;

use Database\Factories\LoginAttemptFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $attempted_at
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $identification
 * @property bool $succeeded
 *
 * @method static \Database\Factories\LoginAttemptFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereAttemptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereSucceeded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereUserId($value)
 *
 * @mixin \Eloquent
 */
class LoginAttempt extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function newFactory(): LoginAttemptFactory
    {
        return LoginAttemptFactory::new();
    }
}
