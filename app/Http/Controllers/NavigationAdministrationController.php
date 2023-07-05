<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class NavigationAdministrationController extends UserBasicController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $allCategories = Category::all()->toArray();
        $allMenuItems = MenuItem::all()->toArray();
        $this->data['available_navigation_items'] = array_merge($allCategories, $allMenuItems);
        $this->data['available_menu_items'] = MenuItem::all();


        return view('admin.navigation', $this->data);
    }
}
