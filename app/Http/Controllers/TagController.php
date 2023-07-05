<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameRequest;
use App\Models\MenuItem;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends UserBasicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::with('posts');

        if(!isset($request->exceptPagination)){
            $tags = $tags->paginate(5);
        }
        else{
            $tags =  $tags->get();
        }

        return handleResponse('Success.', 200, 'success', $tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NameRequest $request)
    {
        $this->authorize('admin', Tag::class);
        try{
            $existingTag = Tag::where('name', 'LIKE', $request->value)->first();
            if($existingTag){
                return handleResponse("Tag with name '{$request->value}' already exist!", 409, 'error');
            }

            Tag::create([
                'name' => $request->value,
            ]);
            return handleResponse('Successfully added tag.', 201, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while adding tags', 500, 'error', $ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $posts = Post::with('author', 'author.image', 'ratings', 'image', 'comments', 'tags', 'categories')->whereHas('tags', function ($query) use ($tag) {
            $query->where('tag_id', $tag->id);
        })
            ->paginate(4);


        $this->data['tag'] = $tag;
        if(request()->expectsJson()){
            return handleResponse('success', 200, 'success', $posts);
        }

        return view('tags.index', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NameRequest $request, Tag $tag)
    {
        $this->authorize('admin', Tag::class);
        try{
            $existingTag = Tag::where('name', 'LIKE', $request->value)->where('id', '!=', $tag->id)->first();
            if($existingTag){
                return handleResponse("Tag with name '{$request->value}' already exist!", 409, 'error');
            }
            $tag->name = $request->value;
            $tag->save();

            return handleResponse('Successfully updated Tag.', 200, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while updating Tag', 500, 'error', $ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('admin', Tag::class);
        try{
            $tag->load('posts');
            if(count($tag->posts) > 0){
                return handleResponse("There are posts with '{$tag->name}' tag", 409, 'error');
            }
            $tag->delete();
            return handleResponse('Successfully deleted Tag.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while deleting tag', 500, 'error', $ex);
        }
    }
}
