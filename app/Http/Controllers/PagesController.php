<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function informasi()
    {
        return view('pages.informasi');
    }

    public function bantuan()
    {
        return view('pages.bantuan');
    }
}
