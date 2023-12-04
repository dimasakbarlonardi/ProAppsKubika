<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class CompanySettingController extends Controller
{
    public function show()
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $connSystem = ConnectionDB::setConnection(new System());

        $data['setting'] = $connSetting->find(1);
        $data['system'] = $connSystem->find(1);

        return view('AdminSite.CompanySetting.show', $data);
    }

    public function update(Request $request)
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $connSystem = ConnectionDB::setConnection(new System());

        $setting = $connSetting->find(1);
        $setting->update($request->all());

        $connSystem = $connSystem->find(1);
        $connSystem->update($request->all());

        $file = $request->file('company_logo');

        if ($file) {
            $storagePath = SaveFile::saveCompanyLogo($request->user()->id_site, 'company_logo', $file);
            $setting->company_logo = $storagePath;
            $setting->save();
        }

        Alert::success('Success', 'Success update profile');

        return redirect()->back();
    }

    public function splitAR()
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        try {
            DB::beginTransaction();

            $setting = $connSetting->find(1);
            $setting->is_split_ar = !$setting->is_split_ar;
            $setting->save();

            DB::commit();
            return response()->json(['status' => 'ok']);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed']);
        }
    }
}
