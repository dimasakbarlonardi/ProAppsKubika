<?php

namespace App\Http\Controllers\API;

use App\Models\Site;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ElectricUUS;
use Carbon\Carbon;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Laravel\Sanctum\PersonalAccessToken;

class BillingController extends Controller
{
    public function insertElectricMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-","|",$token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $data['unit'] = $unit;
            $data['token'] = $token;

            return view('AdminSite.UtilityUsageRecording.Electric.create', $data);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function storeElectricMeter(Request $request, $unitID, $token)
    {
        $getToken = str_replace("RA164-","|",$token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $login = $tokenable->tokenable;
            $site = Site::find($login->id_site);

            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $user = new User();
            $user = $user->setConnection($site->db_name);
            $user = $user->where('login_user', $login->email)->first();

            $connElecUUS = new ElectricUUS();
            $connElecUUS = $connElecUUS->setConnection($site->db_name);

            $connElecUUS->create([
                'periode_bulan' => $request->periode_bulan,
                'periode_tahun' => Carbon::now()->format('Y'),
                'id_unit' => $unitID,
                'nomor_listrik_awal' => $request->previous,
                'nomor_listrik_akhir' => $request->current,
                'usage' => $request->current - $request->previous,
                'id_user' => $user->id_user
            ]);

            Alert::success('Berhasil', 'Berhasil menambahkan data');

            return redirect()->back();

        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function insertWaterMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-","|",$token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);
            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $data['unit'] = $unit;
            $data['token'] = $token;

            return view('AdminSite.UtilityUsageRecording.Water.create', $data);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }
}
