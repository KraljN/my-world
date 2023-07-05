<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameRequest;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends UserBasicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::with('posts');

        if(!isset($request->exceptPagination)){
            $categories = $categories->paginate(5);
        }
        else{
            $categories =  $categories->get();
        }

        return handleResponse('Success.', 200, 'success', $categories);
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
    public function store(NameRequest $request)
    {
        $this->authorize('admin', Category::class);
        try{
            DB::beginTransaction();
            $existingCategory = Category::where('name', 'LIKE', $request->value)->first();
            if($existingCategory){
                return handleResponse("Category with name '{$request->value}' already exist!", 409, 'error');
            }

            $partyId = DB::table('menu_parties')->insertGetId([]);
            Category::create([
                'name' => $request->value,
                'menu_party_id' => $partyId
            ]);

            DB::commit();
            return handleResponse('Successfully added Category.', 201, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while adding Category', 500, 'error', $ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $posts = Post::with('author', 'author.image', 'ratings', 'image', 'comments', 'tags', 'categories')->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })
        ->paginate(4);


        $this->data['category'] = $category;
        if(request()->expectsJson()){
            return handleResponse('success', 200, 'success', $posts);
        }

        return view('categories.index', $this->data);
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
    public function update(NameRequest $request, Category $category)
    {
        $this->authorize('admin', Category::class);
        try{
            $existingCategory = Category::where('name', 'LIKE', $request->value)->where('id', '!=', $category->id)->first();
            if($existingCategory){
                return handleResponse("Category with name '{$request->value}' already exist!", 409, 'error');
            }
            $category->name = $request->value;
            $category->save();

            return handleResponse('Successfully updated Category.', 200, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while updating Category', 500, 'error', $ex);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('admin', Category::class);
        try{
            $category->load('posts');
            if(count($category->posts) > 0){
                return handleResponse("There are posts with '{$category->name}' category", 409, 'error');
            }
            $category->delete();
            return handleResponse('Successfully deleted Category.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while deleting category', 500, 'error', $ex);
        }
    }
}
