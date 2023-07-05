<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\CommentRating;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostRating;
use App\Models\PostTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostController extends UserBasicController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['only' => ['edit', 'index', 'create', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('adminView', Post::class);
        $posts = Post::with('author', 'author.image', 'ratings', 'image', 'comments', 'tags', 'categories')->orderBy('created_at', 'DESC');
        if(auth()->user()->hasRole('writer')){
            $posts->where('user_id', auth()->id());
        }
        $this->data['posts'] = $posts->paginate(4);
        $this->data['roles'] = auth()->user()->getRoleNames();

        if(request()->expectsJson()){
            return handleResponse('success', 200, 'success', $this->data['posts']);
        }

        return view('post.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('adminView', Post::class);

        return view('post.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        try{
            DB::beginTransaction();
            $this->authorize('adminView', Post::class);

            //Create Image
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $request->image->move(public_path('/assets/img'), $imageName);

            $createdImage = Image::create([
                'src' => $imageName,
                'alt' => time().'.'.$image->getFilename()
            ]);

            //Create Post object
            $createdPost = Post::create([
                'title' => $request->title,
                'text' => $request->text,
                'user_id' => \auth()->id(),
                'image_id' => $createdImage->id
            ]);

            //Link Post with Tag
            $tagIds = explode(',', $request->tags);
            $categoryIds = explode(',', $request->categories);
            foreach ($tagIds as $tagId){
                    PostTag::create([
                        'post_id' => $createdPost->id,
                        'tag_id' => $tagId
                    ]);
            }

            //Link Post with Category
            foreach ($categoryIds as $categoryId){
                PostCategory::create([
                    'post_id' => $createdPost->id,
                    'category_id' => $categoryId
                ]);
            }

            DB::commit();
            return handleResponse('Post successfully created.', 201, 'success',);
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while creating Post', 500, 'error', $ex);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('author', 'author.image', 'ratings', 'image', 'comments', 'comments.ratings', 'comments.user', 'comments.user.image', 'tags', 'categories');

        $post->visitsCounter()->increment();

        $this->data['post'] = $post;
        $this->data['auth_user'] = Auth::user();

        return view('post.show', $this->data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);
        $post->load('author', 'author.image', 'ratings', 'image', 'tags', 'categories');
        $this->data['post'] = $post;
        $this->data['roles'] = auth()->user()->getRoleNames();
        //If we want to change author we need list of users that are admins or writers
        $this->data['users'] = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['writer', 'admin']);
        })->get();

        return view('post.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try{
            DB::beginTransaction();
            $this->authorize('edit', $post);
            $post->load('image');

            //Edit Image
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $request->image->move(public_path('/assets/img'), $imageName);

                $createdImage = Image::create([
                    'src' => $imageName,
                    'alt' => time().'.'.$image->getFilename()
                ]);
                $post->image_id = $createdImage->id;

                //Delete old image
                File::delete(public_path('/assets/img/' . $post->image->src));
                Image::find($post->image->id)->delete();
            }

            //Delete old relation with tag
            PostTag::where('post_id', $post->id)->delete();
            //Link Post with Tag
            $tagIds = explode(',', $request->tags);
            $categoryIds = explode(',', $request->categories);
            foreach ($tagIds as $tagId){
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tagId
                ]);
            }


            //Delete old relation with tag
            PostCategory::where('post_id', $post->id)->delete();
            //Link Post with Category
            foreach ($categoryIds as $categoryId){
                PostCategory::create([
                    'post_id' => $post->id,
                    'category_id' => $categoryId
                ]);
            }

            $post->title = $request->title;
            $post->text = $request->text;
            $post->user_id = $request->author_id;
            $post->save();

            $post->load('author', 'author.image', 'ratings', 'image', 'tags', 'categories');
            DB::commit();
            return handleResponse('Post successfully updated.', 200, 'success', $post);
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while updating Post', 500, 'error', $ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('edit', $post);
        try{
            $post->load('comments', 'comments.ratings');

            $comment_ids = $post->comments->pluck('id');
            $comment_rating_ids = [];
            foreach ($post->comments as $comment){
                array_push($comment_rating_ids, $comment->ratings->pluck('id'));
            }
            DB::beginTransaction();
            PostTag::where('post_id', $post->id)->delete();
            PostCategory::where('post_id', $post->id)->delete();
            PostRating::where('post_id', $post->id)->delete();
            CommentRating::whereIn('id', $comment_rating_ids)->delete();
            Comment::whereIn('id', $comment_ids)->delete();
            $post->delete();
            File::delete(public_path('/assets/img/' . $post->image->src));
            Image::find($post->image->id)->delete();

            DB::commit();
            return handleResponse('Successfully deleted post.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while deleting comments', 500, 'error', $ex);
        }
        $this->authorize('edit', $post);
        PostTag::where('post_id', $post->id)->delete();

        dd('Brisi breee');
    }
}
