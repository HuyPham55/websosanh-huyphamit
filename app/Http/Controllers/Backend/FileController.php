<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    //
    use HttpResponses;

    private string $disk = "public_relative";

    public function postImage(Request $request)
    {
        $disk = $this->disk;
        $directoryPrefix = config("filesystems.disks." . $disk . ".url");

        if (!$request->hasFile('image')) {
            return $this->error([]);
        }
        $file = $request->file('image');

        $fileName = $file->getClientOriginalName();


        $directory = "photos/shares";
        $path = Storage::disk($disk)
            ->putFileAs(
                $directory, $file, $fileName
            );
        $relativePath = $directoryPrefix . "/" . $path;
        return $this->success([
            'path' => $relativePath
        ]);

    }
}
