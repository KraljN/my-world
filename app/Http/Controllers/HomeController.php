<?php

namespace App\Http\Controllers;

use App\Mail\AccountConfirmation;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends UserBasicController
{
    public function index()
    {
        $this->data['posts'] = Post::with('author', 'author.image', 'comments', 'image')->latest()->paginate(4);

        return view('home', $this->data);
    }
}
