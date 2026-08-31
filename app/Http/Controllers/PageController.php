<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function technology()
    {
        return view('pages.technology');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
