<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionSubcategory;
use Illuminate\Http\Request;

class QuestionSubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subcategories.index', [
            'question_subcategories' => QuestionSubcategory::all(),
        ]);
    }
}
