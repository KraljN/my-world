<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuItems = MenuItem::paginate(5);

        return handleResponse('Success', 200, 'success', $menuItems);
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
        try{
            DB::beginTransaction();
            $existingMenuItem = MenuItem::where('name', 'LIKE', $request->value)->first();
            if($existingMenuItem){
                return handleResponse("Menu Item with name '{$request->value}' already exist!", 409, 'error');
            }
            $partyId = DB::table('menu_parties')->insertGetId([]);

            MenuItem::create([
                'name' => $request->value,
                'menu_party_id' => $partyId
            ]);
            DB::commit();
            return handleResponse('Successfully added menu item.', 201, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while adding menu item', 500, 'error', $ex);
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
    public function update(NameRequest $request, MenuItem $menuItem)
    {
        try{
            $existingMenuItem = MenuItem::where('name', 'LIKE', $request->value)->where('id', '!=', $menuItem->id)->first();
            if($existingMenuItem){
                return handleResponse("Menu Item with name '{$request->value}' already exist!", 409, 'error');
            }
            $menuItem->name = $request->value;
            $menuItem->save();

            return handleResponse('Successfully updated menu item.', 200, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while updating menu item', 500, 'error', $ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem)
    {
        try{

            $existInMenu = Menu::where('menu_party_id', $menuItem->menu_party_id)->first();
            if($existInMenu){
                return handleResponse("Menu Item with name '{$menuItem->name}' exist in navigation!", 409, 'error');
            }
            $menuItem->delete();

            return handleResponse('Successfully deleted menu item.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            DB::rollBack();
            return handleResponse('There has been error while deleting menu item', 500, 'error', $ex);
        }
    }
}
