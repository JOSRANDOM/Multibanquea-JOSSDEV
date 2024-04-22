<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activity_type_id',
        'object_id',
        'value',
        'old_value',
    ];

    /**
     * Get the activity type.
     */
    public function activityType()
    {
        return $this->belongsTo(ActivityType::class);
    }
}
