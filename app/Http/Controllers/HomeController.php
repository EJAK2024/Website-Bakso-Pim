<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class HomeController
{
    public function index()
    {
        return view('main');
    }

    public function pesan()
    {
        return view('pesan');
    }
}