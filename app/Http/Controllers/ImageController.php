<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();

        return view('images', ['images' => $images]);
    }

    public function upload()
    {
        return view('upload');
    }

    public function uploadPost(Request $request)
    {
        $file = $request->file('file');
        // Generate unique file name
        $fileName = time() . '_' . Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        $storage = new StorageClient([
            'keyFilePath' => base_path('storage/app/credentials.json'),
        ]);

        $bucket = $storage->bucket('20021455_lab6_bucket');

        $bucket->upload(
            fopen($file, 'r'),
            [
                'name' => $fileName,
            ]
        );

        // Save link google cloud image to database
        $image = new Image();
        $image->title = null;
        $image->url = 'https://storage.googleapis.com/20021455_lab6_bucket/' . $fileName;
        $image->save();

        $images = Image::all();

        return redirect()->route('images')->with('images', $images);
    }
}
