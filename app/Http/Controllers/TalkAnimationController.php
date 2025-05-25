<?php

namespace App\Http\Controllers;

use App\Models\TalkAnimation;
use App\Http\Requests\TalkAnimationUpdateRequest;

class TalkAnimationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:talk_animation-list|talk_animation-create|talk_animation-edit|talk_animation-show|talk_animation-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:talk_animation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:talk_animation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:talk_animation-delete', ['only' => ['destroy']]);
        $this->middleware('permission:talk_animation-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talkanimations = TalkAnimation::latest()->get();
        return view('talk_animations.index', compact('talkanimations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talk_animations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TalkAnimationUpdateRequest $request, TalkAnimation $talkAnimation)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}