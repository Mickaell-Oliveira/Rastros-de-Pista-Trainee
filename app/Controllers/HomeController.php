<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class HomeController
{

    public function index()
    {
       $posts = App::get('database')->selectAll('posts');
       return view('landingpage', compact('posts'));
    }
}