<?php

namespace App\Helpers;

use App\Models\Login;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use File;
use Image;

class SaveFile
{
    public static function saveCompanyLogo($idSite, $type, $file)
    {
        $fileName = $type . '-' . Carbon::now()->format('Y-m-d') . '-' .   $file->getClientOriginalName();
        $path = '/public/' . $idSite . '/img/' . $type . '/' . $fileName;
        $storagePath = '/storage/' . $idSite . '/img/' . $type .  '/' . $fileName;
        $img = Image::make($file);
        $img->encode('jpg', 100);

        Storage::disk('local')->put($path, $img);

        return $storagePath;
    }

    public static function saveToStorage($idSite, $type, $file)
    {
        $fileName = $type . '-' . Carbon::now()->format('Y-m-d') . '-' .   $file->getClientOriginalName();
        $path = '/public/' . $idSite . '/img/' . $type . '/' . $fileName;
        $storagePath = '/storage/' . $idSite . '/img/' . $type .  '/' . $fileName;
        $img = Image::make($file);
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 80);

        Storage::disk('local')->put($path, $img);

        return $storagePath;
    }

    public static function saveFileToStorage($idSite, $type, $file)
    {
        $fileName =  $type . '-' .   $file->getClientOriginalName();
        $path = '/public/' . $idSite . '/file/' . $type . '/' . $fileName;
        $storagePath = '/storage/' . $idSite . '/file/' . $type . '/' . $fileName;

        Storage::disk('local')->put($path, File::get($file));

        return $storagePath;
    }
}
