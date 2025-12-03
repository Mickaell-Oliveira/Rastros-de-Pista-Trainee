<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class ListaPostsController
{

    public function ListaPosts()
    {
        $posts = App::get('database')->selectAll('posts');
        return view('site/posts_page', compact('posts'));
    }
}