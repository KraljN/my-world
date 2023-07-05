<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayCategoryTagsAdministrationController extends UserBasicController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
            return view('admin.tags-categories', $this->data);
    }
}
