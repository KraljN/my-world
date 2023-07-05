<?php

namespace App\Http\Controllers;

use App\Http\Requests\NavigationItemRequest;
use App\Models\Comment;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'admin'], ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return handleResponse('Success', 200, 'success', Menu::with('parties', 'parties.category', 'parties.menuItem')->orderBy('order')->get());
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while fetching navigation item', 500, 'error', $ex);
        }
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
    public function store(NavigationItemRequest $request)
    {
        $this->authorize('store', Menu::class);

        try{
            Menu::create([
                'order' => $request->order,
                'route' => $request->route,
                'menu_party_id' => $request->name_id
            ]);
            return handleResponse('Navigation Item successfully created.', 201, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while creating navigation item', 500, 'error', $ex);
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
    public function update(NavigationItemRequest $request, Menu $menu)
    {
        $this->authorize('store', Menu::class);

    try{
        $menu->order = $request->order;
        $menu->route = $request->route;
        $menu->menu_party_id = $request->name_id;
        $menu->save();
        return handleResponse('Navigation Item successfully updated.', 200, 'success');

    }
    catch (\Error | \Exception $ex){
        DB::rollBack();
        return handleResponse('There has been error while updating Navigation Items', 500, 'error', $ex);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $this->authorize('store', Menu::class);

        try{
            Menu::where('id', $menu->id)->delete();
            return handleResponse('Successfully deleted navigation item.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while deleting this navigation item', 500, 'error', $ex);
        }
    }
}
