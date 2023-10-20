<?php

namespace App\Helpers;

use App\Models\Login;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;

class SaveImage {

    public static function saveToStorage($idSite, $type, $file)
    {
        $fileName = $type . '-' . Carbon::now()->format('Y-m-d') . '-' .   $file->getClientOriginalName();
        $path = '/public/' . $idSite . '/img/checkin/' . $fileName;
        $storagePath = '/storage/' . $idSite . '/img/' . $type .  '/' . $fileName;

        $img = Image::make($file);
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 80);

        Storage::disk('local')->put($path, $img);

        return $storagePath;
    }
}
