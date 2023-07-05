<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserBasicInfoRequest;
use App\Mail\ContactMessageReply;
use App\Models\Comment;
use App\Models\CommentRating;
use App\Models\Image;
use App\Models\PostRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class UserController extends UserBasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['only' => ['edit', 'index', 'destroy']]);
        $this->middleware('admin', ['only' => ['index', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['users'] = User::with('roles')->paginate(5);

        if(request()->expectsJson()){
            return handleResponse('success', 200, 'success', $this->data['users']);
        }

        return view('admin.users', $this->data);
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
    public function store(Request $request)
    {
        //
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
    public function edit(User $user)
    {
        $user->load('image', 'roles');
        $this->authorize('update', $user);
        $this->data['user'] = $user;
        $this->data['all_roles'] = Role::all();
        return view('users.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserBasicInfoRequest $request, User $user)
    {
        try{
            $user->load('image');
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $request->image->move(public_path('/assets/img'), $imageName);

                $createdImage = Image::create([
                    'src' => $imageName,
                    'alt' => time().'.'.$image->getFilename()
                ]);
                $user->image_id = $createdImage->id;

                //Delete old image
                File::delete(public_path('/assets/img/' . $user->image->src));
                Image::find($user->image->id)->delete();
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;

            //Delete previous role and set new
            $user->syncRoles($request->role_name);

            $user->save();
            //Load relation with new image
            $user->load('image');
            return handleResponse('Profile data successfully saved.', 200, 'success', $user);
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while updating User Profile', 500, 'error', $ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            DB::beginTransaction();
            $user->load('posts');
            if(count($user->posts) > 0){
                return handleResponse("There are posts linked with this user", 409, 'error');
            }
            Comment::where('user_id', $user->id)->delete();
            PostRating::where('user_id', $user->id)->delete();
            CommentRating::where('user_id', $user->id)->delete();
            ContactMessageReply::where('user_id', $user->id)->delete();
            $user->delete();
            DB::commit();
            return handleResponse('Successfully deleted User.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while deleting User', 500, 'error', $ex);
        }
    }
}
