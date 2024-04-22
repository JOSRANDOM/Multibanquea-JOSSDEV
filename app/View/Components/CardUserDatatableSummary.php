<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\User;

class CardUserDatatableSummary extends Component
{
    public $exam;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $user = User::findOrFail(Auth::id());

        return view('components.card-user-datatable-summary',['user'=>$user]);
    }
}
