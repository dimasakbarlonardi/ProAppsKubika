<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\EngBAPP;
use Illuminate\Http\Request;
use Psy\Util\Str;

class EngBAPPcontroller extends Controller
{
    public function index()
    {
        $connEngBAPP = ConnectionDB::setConnection(new EngBAPP());

        $data['engs'] = $connEngBAPP->get();

        return view('AdminSite.EngBAPP.index', $data);
    }

    public function create()
    {
        return view('AdminSite.EngBAPP.create');
    }

    public function store(Request $request)
    {
        $connEngBAPP = ConnectionDB::setConnection(new EngBAPP());

        $nama_eng_bapp = \Str::slug($request->nama_eng_bapp);

        $connEngBAPP->create([
            'nama_eng_bapp' => $nama_eng_bapp,
            'subject' => $request->nama_eng_bapp,
            'dsg' => $request->dsg
        ]);

        return redirect()->route('eng-bapp.index');
    }
}
