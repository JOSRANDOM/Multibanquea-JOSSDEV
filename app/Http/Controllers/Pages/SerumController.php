<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;


class SerumController extends Controller
{
    public function index(){

        return view('pages.serum.index');
    }
}
