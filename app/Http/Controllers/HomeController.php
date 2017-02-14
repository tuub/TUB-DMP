<?php

namespace App\Http\Controllers;
use View;

class HomeController extends Controller
{
    public function index()
    {
        return View::make('home');
    }
}