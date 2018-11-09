<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Specialty;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->paginate(25);
        $specialties = Specialty::all();

        return view('tags.index', compact('tags', 'specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $this->authorize('create', Tag::class);
        
        $request->merge(['user_id' => auth()->id()]);
        
        $tag = Tag::create($request->all());

        flash($tag->name . ' created successfully')->success();

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $specialties = Specialty::all();

        return view('tags.show', compact('tag', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        // dd($request->all());
        $this->authorize('edit', $tag);

        if ($tag->update($request->all())){
            flash($tag->name . ' updated successfully')->success();
        }

        return redirect()->route('tags.show', $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        
        if ($tag->delete()){
            flash($tag->name . ' deleted successfully')->info();
        }

        return redirect()->route('tags.index');
    }
}
