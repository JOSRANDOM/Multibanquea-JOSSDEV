<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        return view('admin.plans.index', [
            'menu'=>'plans',
            'smenu'=>'',
            'active_plans_count' => Plan::all()->where('active', true)->count(),
            'plans' => Plan::paginate(50),
        ]);
    }

    /**
     * Toggle "active" state of plan.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(Plan $plan)
    {
        $current_active_state = $plan->active;

        $plan->active = !$current_active_state;
        $plan->save();

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'public' => 'required|boolean',
            'name' => 'required|alpha_dash|min:4|unique:App\Models\Plan,name',
            'title' => 'required|min:4',
            'months' => 'required|min:1',
            'monthly_price' => 'required',
        ]);

        $monthly_price = $validated['monthly_price'] * 100;

        $plan = Plan::create([
            'public' => $validated['public'],
            'name' => $validated['name'],
            'title' => $validated['title'],
            'months' => $validated['months'],
            'monthly_price' => $monthly_price,
        ]);

        return redirect()->route('admin.plans.show', $plan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return view('admin.plans.show', [
            'plan' => $plan,
        ]);
    }
}
