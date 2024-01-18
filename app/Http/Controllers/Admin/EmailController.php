<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Mail\MonthlyOtherBillMail;
use App\Models\CompanySetting;
use App\Models\MonthlyArTenant;
use App\Models\Site;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request; // Pastikan use statement ini benar

class EmailController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting()); 
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['transaction'] = $connAR->get();
        $data['setting'] = $connSetting->find(1);

        // Kirim email menggunakan MonthlyOtherBillMail

        return view('emails.monthlyOtherBilling', $data);
    }


    // Metode lainnya...

}
