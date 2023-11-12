<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\BAPP;
use Illuminate\Http\Request;

class BAPPController extends Controller
{
    public function show($id)
    {
        $connBAPP = ConnectionDB::setConnection(new BAPP());

        $bapp = $connBAPP->find($id);

        return ResponseFormatter::success(
            $bapp,
            'Success get bapp'
        );
    }
}
