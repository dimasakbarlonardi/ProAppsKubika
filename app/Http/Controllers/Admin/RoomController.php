<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Helpers\ConnectionDB;
use App\Imports\RoomImport;
use App\Imports\UnitImport;
use App\Models\Floor;
use App\Models\Tower;
use App\Models\Login;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Excel;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Room());

        $data['rooms'] = $conn->paginate(10);

        return view('AdminSite.Room.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conntower = ConnectionDB::setConnection(new Tower());
        $connfloor = ConnectionDB::setConnection(new Floor());

        $data['towers'] = $conntower->orderBy('created_at', 'ASC')->get();
        $data['floors'] = $connfloor->orderBy('created_at', 'ASC')->get();

        return view('AdminSite.Room.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Room());

        try {

            DB::beginTransaction();

            $id_user = $request->user()->id;
            $login = Login::where('id', $id_user)->with('site')->first();
            $site = $login->site->id_site;

            $createRoom = $conn->create([
                'id_room' => $request->id_room,
                'id_site' => $site,
                'id_tower' => $request->id_tower,
                'id_lantai' => $request->id_lantai,
                'barcode_room' => $request->barcode_room,
                'nama_room' => $request->nama_room,
            ]);

            $createRoom->GenerateBarcode();

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Room ');

            return redirect()->route('rooms.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Room');

            return redirect()->route('rooms.index');
        }
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
        $conn = ConnectionDB::setConnection(new Room());
        $conntower = ConnectionDB::setConnection(new Tower());
        $connfloor = ConnectionDB::setConnection(new Floor());

        $data['room'] = $conn->find($id);
        $data['towers'] = $conntower->get();
        $data['floors'] = $connfloor->get();

        return view('AdminSite.Room.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Room());

        $room = $conn->find($id);
        $room->update($request->all());
        $room->GenerateBarcode();

        Alert::success('Berhasil', 'Berhasil mengupdate Room');

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Room());

        $conn->find($id)->delete();
        Alert::success('Berhasil', 'Berhasil Menghapus Room');

        return redirect()->route('rooms.index');
    }

    public function viewRoom($idSite, $id)
    {
        $site = Site::find($idSite);


        $room = new Room();
        $room = $room->setConnection($site->db_name);
        $room = $room->where('id_room', $id)->with('InspectionEng')->first();
        $data['room'] = $room;

        return view('AdminSite.Room.view-room', $data);
    }

    public function import(Request $request)
    {
        $file = $request->file('file_excel');

        Excel::import(new RoomImport(), $file);

        Alert::success('Success', 'Success import data');

        return redirect()->route('rooms.index');
    }
}
