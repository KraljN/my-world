<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
        $queryValue = request('query');

// TODO Ovo se mora probati, ali nije na listi prioriteta
// DA LI OVO RADI TREBA ISTESTIRATI DA SE SKLONE TAGOVI IZ TEXTA
//        Book::select([
//  'id',
//  'title',
//  DB::raw("ExtractValue(description, '//text()') as description")
// ])
//->where('status', 'published')
//->get();



        $filteredPosts = Post::with('author', 'author.image', 'ratings', 'image', 'comments', 'tags', 'categories')
            ->where('title', 'LIKE', '%' . $queryValue .'%')
            ->orWhere('text', 'LIKE', '%' . $queryValue .'%')
            ->orWhereHas('author', function ($query) use ($queryValue) {
                $query->where('username', 'LIKE', '%' . $queryValue .'%');
            })
            ->orWhereHas('tags', function ($query) use ($queryValue) {
                $query->where('name', 'LIKE', '%' . $queryValue .'%');
            })
            ->orWhereHas('categories', function ($query) use ($queryValue) {
                $query->where('name', 'LIKE', '%' . $queryValue .'%');
            })
            ->paginate(4);

        return handleResponse('success', 200, 'success', $filteredPosts);
    }
}
