<?php

namespace RomaMb\Press\Http\Controllers;

use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index(): string
    {
        return '<h1>Blog Controller...</h1>;';
    }
}
