<?php

namespace Database\Factories;

use App\Models\ActivityType;
use App\Models\Answer;
use App\Models\CheckoutReference;
use App\Models\Exam;
use App\Models\Plan;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\QuestionSubcategory;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserActivityLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $activity_type = ActivityType::all()->random();

        switch ($activity_type->object_type) {
            case 'ANSWER':
                $object_id = Answer::all()->random();
                break;
            case 'CHECKOUT_REFERENCE':
                $object_id = CheckoutReference::all()->random();
                break;
            case 'EXAM':
                $object_id = Exam::all()->random();
                break;
            case 'PLAN':
                $object_id = Plan::all()->random();
                break;
            case 'QUESTION':
                $object_id = Question::all()->random();
                break;
            case 'QUESTION_CATEGORY':
                $object_id = QuestionCategory::all()->random();
                break;
            case 'QUESTION_SUBCATEGORY':
                $object_id = QuestionSubcategory::all()->random();
                break;
            case 'SUBSCRIPTION':
                $object_id = Subscription::all()->random();
                break;
            case 'USER':
                $object_id = User::all()->random();
                break;
            default:
                $object_id = null;
                break;
        }

        return [
            'user_id' => User::all()->random(),
            'activity_type_id' => $activity_type->id,
            'object_id' => $object_id,
            'value' => $this->faker->word(),
            'old_value' => $this->faker->word(),
        ];
    }
}
