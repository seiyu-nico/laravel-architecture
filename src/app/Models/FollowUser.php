<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'follow_users';

    protected $fillable = [
        'user_id',
        'follow_user_id',
    ];

    public function followerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
