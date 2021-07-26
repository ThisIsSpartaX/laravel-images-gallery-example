<?php

namespace App\Http\Controllers\Picture;

use Illuminate\Http\Request;
use App\Models\Picture\Picture;
use App\Services\PictureService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Picture\Requests\StorePictureRequest;
use App\Http\Controllers\Picture\Requests\StoreExternalPictureRequest;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    /**
     * Show Pictures List
     *
     * @return ViewFactory|View
     */
    public function index()
    {
        $pictures = Picture::query()->orderBy('id', 'DESC')->paginate(100);

        return view('pictures/index', compact('pictures'));
    }

    /**
     * Show Picture Create Form
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function create()
    {
        return view('pictures/create');
    }

    /**
     * View Picture
     *
     * @param string $hash
     * @return ViewFactory|View
     */
    public function view(string $hash)
    {
        $picture = Picture::query()->where('hash', $hash)->firstOrFail();

        return view('pictures/view', compact('picture'));
    }

    /**
     * Store Uploaded Picture
     *
     * @param StorePictureRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(StorePictureRequest $request): RedirectResponse
    {
        $pictureService = new PictureService();

        $uploadedFile = $request->file('picture');
        $fileContent = File::get($uploadedFile->getRealPath());
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
     * @param StoreExternalPictureRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function externalStore(StoreExternalPictureRequest $request): RedirectResponse
    {
        $pictureService = new PictureService();

        try {
            $response = $pictureService->getByUrl($request->get('url'));

            $fileContent = $response->getBody();
            $mimes = new \Mimey\MimeTypes;
            $fileExtension = $mimes->getExtension($response->getHeaderLine('Content-Type'));

            $picture = $pictureService->process($fileContent, $fileExtension);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }

        return redirect()->route('pictures.view', $picture->hash);
    }

    /**
     * Download Picture
     *
     * @param Request $request
     * @param string $hash
     * @return ViewFactory|View|BinaryFileResponse
     * @throws
     */
    public function download(Request $request, string $hash)
    {
        /** @var Picture $picture */
        $picture = Picture::query()->where('hash', $hash)->firstOrFail();

        $compress = $request->query('compress');

        if(!$request->has('compress')) {
            $compress = 'original';
        }

        $disk = Storage::disk('s3');

        try {
            $file = $disk->get(PictureService::getPicturesS3Directory() . '/' . $compress . '/' . $picture->filename);
        }
        catch (\Exception $e) {
            return view('partials.errors', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
        }

        $mimeType = $disk->getMimetype(PictureService::getPicturesS3Directory() . '/' . $compress . '/' . $picture->filename);

        $fileName = File::name($picture->filename) . '_' . $compress . '.' . File::extension($picture->filename);

        $headers = [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'attachment; filename="'. $fileName .'"',
        ];

        return response()->make($file, 200, $headers);
    }
}