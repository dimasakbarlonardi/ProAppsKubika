<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function sites()
    {
        $sites = Site::get(["id_site", "nama_site"]);

        return ResponseFormatter::success($sites, 'Data order user berhasil diambil');
    }
}
