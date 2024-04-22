<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'plan_id',
        'ends_at',
        'starts_at',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ends_at' => 'datetime',
        'starts_at' => 'datetime',
    ];

    /**
     * The plan of the subscription.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * The user subscribed.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Whether the subscription is currently active.
     * 
     * @return boolean
     */
    public function isActive()
    {
        $starts_in_the_past = $this->starts_at <= now();
        $ends_in_the_future = $this->ends_at >= now();

        if ($starts_in_the_past && $ends_in_the_future) {
            return true;
        }

        return false;
    }
}
