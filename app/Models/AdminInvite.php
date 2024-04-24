<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminInvite whereUserId($value)
 *
 * @mixin \Eloquent
 */
class AdminInvite extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
