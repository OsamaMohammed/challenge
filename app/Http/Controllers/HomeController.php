<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Link;
use App\Models\Snippet;

class HomeController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'files':
                return File::orderBy('created_at', 'desc')->get();
            case 'links':
                return Link::orderBy('created_at', 'desc')->get();
            case 'snippets':
                return Snippet::orderBy('created_at', 'desc')->get();
        }
    }
}
