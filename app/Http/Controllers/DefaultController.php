<?php

namespace App\Http\Controllers;

class DefaultController extends Controller
{
    public function list()
    {
        return view('tasks_list');
    }

    public function docs() {
        return 'docs';
    }
}
