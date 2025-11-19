<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class AdminController
{

    public function index()
    {
        $posts = App::get('database') -> selectAll('posts');
        return view('admin/PostChart', ['posts' => $posts]);
    }
}

?>
