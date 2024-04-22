<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = ($request->term && $request->term!='') ? $request->term : '';
        $status = ($request->status && $request->status != 'all') ? $request->status : '';
        // dd($term,$status);
        // if($request->term){
        //     $term = $request->term;
        //     $plans_with_promo_code = Plan::whereNotNull('promo_code')
        //         ->where('slug', 'like', '%' . $term. '%')
        //         ->get();
        // } else {
        //     $plans_with_promo_code = Plan::whereNotNull('promo_code')->get();
        // }

        // $active_plans = $plans_with_promo_code->where('active', true);
        // $inactive_plans = $plans_with_promo_code->where('active', false);
        $plans =  Plan::whereNotNull('promo_code');
        // if($term!=''){
        //     $plans->where('name', 'like', '%' . $term. '%');
        //             // ->orWhere(function($query,$term) {
        //             //     $query->where('name','LIKE', '%'.$term.'%');
        //             //         // ->where('votes', '>', 50);
        //             // });
        //             // ->orWhere('promo_code','LIKE', '%'.$term.'%')
        //             // ->orWhere('name','LIKE', '%'.$term.'%')  ;
        //     // dd($plans->get());
        // }
        if($status != ''){
            $nstatus = ($status=='active') ? 1 : 0;
            $plans->where('active', $nstatus);

        }
        if (strlen($term) > 0) {
            $plans->where(function ($plans) use ($term) {
                $plans->where("slug", "LIKE", "%" . $term . "%")
                ->orWhere("promo_code", "LIKE", "%" . $term . "%")
                ->orWhere("id", "LIKE", "%" . $term . "%")
                ->orWhere("promo_code", "LIKE", "%" . $term . "%")
                ->orWhere("months", "LIKE", "%" . $term . "%")
                ->orWhere("monthly_price", "LIKE", "%" . $term . "%");
            });
        }
        $plans->orderBy('id','desc');
        /**
         * Display view.
         */

        return view('admin.promo-codes.index', [
            'total' => $plans->count(),
            'active_plans' => $plans->paginate(20)->appends([
                'status' => $status,
                'term' => $term,
            ]),
            'inactive_plans' => [],
            'term' => $term,
            'status' => $status,
        ]);
    }

    /**
     * Create a plan with promo code.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'promo_code' => 'required|string|unique:plans,promo_code',
            'plan_name' => 'required|string',
            'monthly_price' => 'required|numeric',
            'months' => 'required|numeric',
        ]);

        switch ($validated['months']) {
            case 1:
                $slug_prepend = '1-mes-promo-';
                break;
            default:
                $slug_prepend = $validated['months'] . '-meses-promo-';
                break;
        }

        $plan = Plan::create([
            'slug' => $slug_prepend . Str::slug($validated['promo_code']),
            'promo_code' => $validated['promo_code'],
            'name' => $validated['plan_name'],
            'months' => $validated['months'],
            'monthly_price' => $validated['monthly_price'] * 100,
            'active' => true,
            'public' => true,
            'protected' => false,
            'featured' => false
            // 'user_id' => Auth::user()->id
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'plan' => 'required|exists:plans,id',
            'active' => 'required|boolean',
        ]);

        $plan = Plan::find($validated['plan']);
        $plan->active = $validated['active'];
        $plan->save();

        // return redirect()->back();
        return response()->json(['error' => false]);
    }
}
