<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function getTags(Request $request, $id, $tag_type) {

        $term = $request->input('term');

        $entries = Tag::where('unique_id', $id)
                ->where('tag_type', $tag_type)
                ->where('tags', 'like', '%' . $term . '%')
                ->get();
        $tags = [];

        foreach ($entries as $entry) {
            $tags_string = explode(',', $entry->tags);
            foreach ($tags_string as $string) {
                $tags[] = $string;
            }
        }

        return $tags;
    }

    public function addTag(Request $request) {

        $unique_id = $request->input('unique_id');
        $tag_type = $request->input('tag_type');
        $tags = $request->input('tags');

        $tag_exists = Tag::where('unique_id',$unique_id)->where('tag_type',$tag_type)->count();

        if ($tag_exists === 0) {

            $new_tag = new Tag([
                'unique_id' => $unique_id,
                'tag_type' => $tag_type,
                'tags' => $tags
            ]);
            $new_tag->save();
        } else {
            $update_tags = Tag::where('unique_id',$unique_id)->where('tag_type',$tag_type)->update([
                'tags' => $tags
            ]);
        }

        return $tag_type;
    }

}
