<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        $connPackage = ConnectionDB::setConnection(new Package());
        $time = Carbon::now()->format('dmY');
        $package_receipt_number = rand(0, 1000);

        $connPackage->package_receipt_number = $time . $package_receipt_number;
        $connPackage->received_location = $request->received_location;
        $connPackage->receive_date = $request->receive_date;
        $connPackage->receive_time = $request->receive_time;
        $connPackage->courier_type = strtoupper($request->courier_type);
        $connPackage->courier_name = Str::title($request->courier_name);
        $connPackage->unit_id = $request->unit_id;
        $connPackage->receiver_id = $request->receiver_id;
        $connPackage->id_site = $request->id_site;
        $connPackage->GenerateBarcode();
        $connPackage->status = 'Arrived';
        $connPackage->save();

        return ResponseFormatter::success(
            $connPackage,
            'Success store package'
        );
    }

    public function packageByUnit($id)
    {
        $connPackage = ConnectionDB::setConnection(new Package());

        $packages = $connPackage->where('unit_id', $id)
            ->with('Unit')
            ->get();

        return ResponseFormatter::success(
            $packages,
            'Success get packages by unit'
        );
    }

    public function pickupPackage($id, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);
        $connPackage = ConnectionDB::setConnection(new Package());

        if ($tokenable) {
            $package = $connPackage->find($id);
            $package->status = 'Picked Up';
            $package->save();

            return ResponseFormatter::success(
                $package,
                'Get pickup package'
            );
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }
}
