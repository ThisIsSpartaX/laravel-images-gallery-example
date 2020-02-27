<?php

namespace App\Http\Controllers\Picture;

use App\Models\Picture\Picture;
use App\Services\PictureService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Picture\Requests\StorePictureRequest;

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
     * @param StorePictureRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(StorePictureRequest $request)
    {
        $pictureService = new PictureService();

        $uploadedFile = $request->file('picture');
        $fileContent = \File::get($uploadedFile->getRealPath());
        $fileExtension = $uploadedFile->getClientOriginalExtension();

        try {
            $picture = $pictureService->process($fileContent, $fileExtension);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('pictures.view', $picture->hash);
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