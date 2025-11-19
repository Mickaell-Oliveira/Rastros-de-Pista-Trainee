<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class ExampleController
{

    public function index()
    {
        $posts = App::get('database') -> selectAll('posts');
        return view('admin/PostChart', $posts);
    }
}

?>
