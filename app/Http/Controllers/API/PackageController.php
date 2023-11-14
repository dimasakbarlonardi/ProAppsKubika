<?php

namespace App\Http\Controllers\API;

use App\Events\HelloEvent;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Site;
use App\Models\TenantUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use File;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $connPackage = ConnectionDB::setConnection(new Package());

        $packages = $connPackage->where('deleted_at', null)
            ->with(['Unit', 'Receiver'])
            ->get();

        return ResponseFormatter::success(
            $packages,
            'Success get packages by unit'
        );
    }

    public function store(Request $request)
    {
        $connPackage = ConnectionDB::setConnection(new Package());
        $connTU = ConnectionDB::setConnection(new TenantUnit());
        // $connUser = ConnectionDB::setConnection(new User());

        $time = Carbon::now()->format('dmY');
        $package_receipt_number = rand(0, 1000);
        $package_receipt_number = $time . $package_receipt_number;
        // $user = $connUser->where('login_user', $request->user()->email)->first();
        $tenants = $connTU->where('id_unit', $request->unit_id)->get();

        $connPackage->package_receipt_number = $package_receipt_number;
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

        $file = $request->file('image');
        if ($file) {
            $fileName = $connPackage->package_receipt_number . '-' .   $file->getClientOriginalName();
            $outputPackageImage = '/public/' . $request->user()->id_site . '/img/package/' . $fileName;
            $packageImage = '/storage/' . $request->user()->id_site . '/img/package/' . $fileName;

            Storage::disk('local')->put($outputPackageImage, File::get($file));

            $connPackage->image = $packageImage;
        }

        $connPackage->save();

        foreach ($tenants as $tenant) {
            $dataNotif = [
                'models' => 'Package',
                'notif_title' => $connPackage->package_receipt_number,
                'id_data' => $connPackage->id,
                'sender' => $connPackage->receiver_id,
                'division_receiver' => null,
                'notif_message' => 'Halo, paket mu sudah sampai. Terima kasih..',
                'receiver' => $tenant->Tenant->User->id_user,
            ];

            broadcast(new HelloEvent($dataNotif));
        }

        return ResponseFormatter::success(
            $connPackage,
            'Success store package'
        );
    }

    public function packageByUnit($id)
    {
        $connPackage = ConnectionDB::setConnection(new Package());

        $packages = $connPackage->where('unit_id', $id)
            ->with(['Unit', 'Receiver'])
            ->get();

        return ResponseFormatter::success(
            $packages,
            'Success get packages by unit'
        );
    }

    public function showPackage($id)
    {
        $connPackage = ConnectionDB::setConnection(new Package());

        $packages = $connPackage->where('id', $id)
            ->with(['Unit', 'Receiver'])
            ->first();

        return ResponseFormatter::success(
            $packages,
            'Success get packages by unit'
        );
    }

    public function pickupPackage($id, Request $request)
    {
        $connPackage = ConnectionDB::setConnection(new Package());
        $connUser = ConnectionDB::setConnection(new User());

        $login = $request->user();

        if ($login) {
            $user = $connUser->where('login_user', $login->email)->first();

            $package = $connPackage->find($id);
            $package->picked_by = $user->id_user;
            $package->status = 'Picked Up';
            $package->picked_time = Carbon::now();
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
