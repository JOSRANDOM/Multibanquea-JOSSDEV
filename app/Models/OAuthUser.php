<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'nickname',
        'name',
        'email',
        'email_requested',
        'email_requested_request_token',
        'email_requested_response_token',
        'email_requested_response_token_created_at',
        'avatar',
    ];

    /**
     * The user linked to the OAuth user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
