<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutReference extends Model
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
        'total_price',
        'amount_paid',
    ];

    /**
     * The plan that has the checkout reference.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * The user that has the checkout reference.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Whether the checkout reference has been fully paid.
     * 
     * @return boolean
     */
    public function isPaid()
    {
        return $this->amount_paid >= $this->total_price;
    }
}
