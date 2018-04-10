<?php

namespace App\Http\Controllers;

use App\Models\LinkCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;

class LinkCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = LinkCategory::all();

        return view('linkCategory.index',[
            'assets' => ['table'],
            'categories' => $categories
        ]);
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
    public function store(Request $request)
    {
        $linkCategory = new LinkCategory($request->all());
        $linkCategory->save();

        $categories = LinkCategory::all();

        return !array_key_exists('request_from_link_page',$request->all()) ? redirect()->route('linkCategory.index') : json_encode($categories);
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
        $cat = LinkCategory::find($id);

        return view('linkCategory.edit', [
            'category'=> $cat
        ]);
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
        /** @var  $linkCategory LinkCategory */

        $linkCategory = LinkCategory::find($id);
        $linkCategory->update($request->all());

        return redirect()->route('linkCategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var  $linkCategory LinkCategory*/
        $linkCategory = LinkCategory::find($id);
        $linkCategory->delete();

        return redirect()->route('linkCategory.index');
    }
}
