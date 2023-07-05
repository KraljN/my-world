<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class AvailableNavigationItemsController extends Controller
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
        return handleResponse('success', 200, 'success', array_merge($allCategories, $allMenuItems));
    }
}
