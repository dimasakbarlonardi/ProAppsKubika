<?php

namespace App\Http\Controllers\API;

use App\Models\Site;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class BillingController extends Controller
{
    public function insertElectricMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-","|",$token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            dd($token, $getToken, $tokenable);
            $user = $token->tokenable;
            $site = Site::find($user->id_site);

            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $data['unit'] = $connUnit->where('id_unit', $unitID)->first();

            return view('AdminSite.UtilityUsageRecording.Electric.create', $data);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
        dd($token);
    }
}
