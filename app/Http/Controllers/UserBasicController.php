<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBasicController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['tags'] = Tag::with('posts')->get();
        $categories = Category::with('posts')->get();
        foreach ($categories as $category){
            $posts = PostCategory::where('category_id', $category->id)->get();
            $category->count = count($posts);
        }
        $this->data['categories'] = $categories;

        $topIds = visits(Post::class)->topIds(3);
        $this->data['mostPopular'] = [];
        foreach ($topIds as $topId){
            $this->data['mostPopular'][] = Post::with('author', 'author.image', 'ratings', 'image', 'comments', 'comments.ratings', 'comments.user', 'comments.user.image', 'tags', 'categories')->find($topId);
        }
    }
}
