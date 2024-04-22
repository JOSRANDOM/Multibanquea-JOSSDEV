<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlashCard;
use App\Models\FlashCardCategory;
class FlashCardsController extends Controller
{
    //
    public function index(){
        $categories = FlashCardCategory::where('active',1)->orderBy('name','ASC')->get();
        // dd($cards);
        return view('flash-cards.index', [
            'categories' => $categories
        ]);
    }
    public function category($slug){

        $category = FlashCardCategory::where('slug',$slug)->first();
        if($category){


            $cards = FlashCard::where('category_id',$category->id)->where('active',1)->orderBy('position','ASC')->get();
            // dd($cards);
            return view('flash-cards.category', [
                'category' => $category,
                'cards' => $cards
            ]);
        }else{
            return redirect()->route('flash-cards.index');
        }
    }
}
