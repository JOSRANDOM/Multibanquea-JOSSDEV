<?php

namespace App\Models;

use App\Models\Exam;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'admin_level',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'phone',
        'study_center',
        'study_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'admin_level',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The user activities from the activity log.
     */
    public function activities()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    /**
     * The check references that belong to the user.
     */
    public function checkout_references()
    {
        return $this->hasMany(CheckoutReference::class);
    }

    /**
     * The exams that belong to the user.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * The completed exams that belong to the user.
     */
    public function exams_completed()
    {
        return $this->hasMany(Exam::class)
            ->whereNotNull('completed_at');
    }

    /**
     * The exams in progress that belong to the user.
     */
    public function exams_in_progress()
    {
        return $this->hasMany(Exam::class)
            ->whereNull('completed_at');
    }

    /**
     * The OAuth users linked to the user.
     */
    public function o_auth_users()
    {
        return $this->hasMany(OAuthUser::class);
    }

    /**
     * The plans that belong to the user.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    /**
     * Get subscriptions the belong to the user.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * The latests active subscription that belongs to the user.
     */
    public function active_subscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('ends_at', '>=', now())
            ->where('starts_at', '<=', now())
            ->orderByDesc('ends_at')
            ->limit(1);
    }

    /**
     * Get the user active subscriptions.
     */
    public function active_subscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->where('ends_at', '>=', now())
            ->where('starts_at', '<=', now());
    }

    /**
     * Whether the user has an exam in progress.
     *
     * @return boolean
     */
    public function hasExamInProgress()
    {
        $user_product_exams_in_progress_count = $this->exams()
            ->whereNull('completed_at')
            ->count();

        if ($user_product_exams_in_progress_count > 0) {
            return true;
        }

        return false;
    }

    /**
     * Checks whether the user is an admin.
     */
    public function is_admin()
    {
        if ($this->admin_level === 1) {
            return true;
        }

        return false;
    }

    /**
     * Checks whether the user has an active subscription.
     */
    public function isSubscribed()
    {
        $active_subscriptions = $this->subscriptions()
            ->where('ends_at', '>=', now())
            ->where('starts_at', '<=', now())
            ->count();

        if ($active_subscriptions > 0) {
            return true;
        }

        return false;
    }

    /**
     * Checks whether the user has the courses subscription active.
     */
    public function isSubscribedWithCourses()
    {
        $active_subscriptions = $this->subscriptions()
            ->where('ends_at', '>=', now())
            ->where('starts_at', '<=', now())
            ->where('plan_id', '=', 16)
            ->count();

        if ($active_subscriptions > 0) {
            return true;
        }

        return false;
    }

    /**
     * Define Trello user and list for notification.
     *
     * @return Array
     */
    public function routeNotificationForTrello()
    {
        return [
            'token' => config('services.trello.token'),
            'idList' => config('services.trello.list'),
        ];
    }
}
