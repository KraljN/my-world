<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
            try{
                $createdComment = Comment::create([
                    'text' => $request->comment_text,
                    'post_id' => $request->post_id,
                    'user_id' => $request->user_id
                ]);

                $comment = Comment::with('user', 'user.image', 'ratings')->find($createdComment->id);
                return handleResponse('Comment successfully created.', 201, 'success', $comment);

            }
            catch (\Error | \Exception $ex){
                return handleResponse('There has been error while creating comment', 500, 'error', $ex);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Comment::where('id', $id)->delete();
            return handleResponse('Successfully deleted comment.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while deleting this comment', 500, 'error', $ex);
        }
    }
}
