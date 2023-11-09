<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Helpers\SaveFile;
use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompanySettingController extends Controller
{
    public function show()
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        $data['setting'] = $connSetting->find(1);

        return view('AdminSite.CompanySetting.show', $data);
    }

    public function update(Request $request)
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());

        $setting = $connSetting->find(1);
        $setting->update($request->all());

        $file = $request->file('company_logo');

        if ($file) {
            $storagePath = SaveFile::saveCompanyLogo($request->user()->id_site, 'company_logo', $file);
            $setting->company_logo = $storagePath;
            $setting->save();
        }

        Alert::success('Success', 'Success update profile');

        return redirect()->back();
    }
}
