<?php

namespace App\Http\Controllers\Picture;

use App\Models\Picture\Picture;
use App\Http\Controllers\Controller;

class PictureController extends Controller
{
    /**
     * Show Pictures List
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pictures = Picture::all();

        return view('pictures/index', compact('pictures'));
    }

    /**
     * Show Picture Create Form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pictures/create');
    }

    /**
     * View Picture
     *
     * @param string $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($hash)
    {
        $picture = Picture::where('hash', $hash)->firstOrFail();

        return view('pictures/view', compact('picture'));
    }

    /**
     * Store Uploaded Picture
     *
     */
    public function store()
    {

    }

    /**
     * Store External Picture
     *
     */
    public function externalStore()
    {

    }

    /**
     * Download Picture
     *
     */
    public function download()
    {

    }
}