<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\KepemilikanUnit;
use App\Models\OwnerH;
use App\Models\OwnerOFF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffBoardingOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ownerByID($id)
    {
        $connowner = ConnectionDB::setConnection(new OwnerH());

        $owner = $connowner->where('id_pemilik', $id)->first();
        
        $nama_unit = [];

        foreach ($owner->Kepemilikan as $unit) {
            $nama_unit[] = $unit->Unit->nama_unit;
        };

        return response()->json([
            'owner' => $owner,
            'nama_unit' => $nama_unit
        ]);
    }
    
    // $owner = DB::connection(Auth::user()->Site->db_name)
    //     ->table('tb_pemilik_h as o')
    //     ->select('o.nama_kontak_pic', 'u.nama_unit')
    //     ->where('o.id_pemilik', $id)
    //     ->leftJoin('tb_pemilik_d as d', 'o.id_pemilik', 'd.id_pemilik')
    //     ->join('tb_unit as u', 'u.id_unit', '=', 'd.id_unit')
    //     ->first();
    
    // public function picByID($id)
    // {
    //     $owner = ConnectionDB::setConnection(new OwnerH());

    //     $owner = $owner->where('id_pemilik', $id)->first();

    //     return response()->json(['unit' => $owner]);
    // }


    public function index()
    {
        $connowner = ConnectionDB::setConnection(new OwnerH());
        $conn = ConnectionDB::setConnection(new OwnerOFF());

        $data['owners'] = $connowner->get();
        $data['offowners'] = $conn->get();

        return view('AdminSite.OffBoardingOwner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
