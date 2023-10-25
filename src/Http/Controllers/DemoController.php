<?php

namespace Stew\ImageUploader\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Stew\ImageUploader\Models\Media;
use Stew\ImageUploader\Traits\UploaderTrait;

class DemoController extends Controller
{
    use UploaderTrait;
    public function index ()
    {
        $medias = Media::all();

        return view('demo::index', compact('medias'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store (Request $request): RedirectResponse
    {
        $input['name'] = $this->saveFileToStorage($request->image_base64, '/uploads/');
        $input['thumbnail_img'] = $this->saveFileToStorage($request->thumbnail_img, '/uploads/');
        $input['original_name'] = $request->original_name;
        \DB::table('media')->truncate();
        Media::create($input);

        return back()->with('success', 'Image uploaded successfully.');
    }
}
