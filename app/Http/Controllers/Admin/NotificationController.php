<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Helpers\ConnectionDB;
use App\Models\User;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Notification());
        $user_id = $request->user()->id;

        $data ['notifications'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.Notification.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $connuser = ConnectionDB::setConnection(new User());
        $user_id = $request->user()->id;

        $data['idusers'] = Login::where('id', $user_id)->get();
        $data['users'] = $connuser->get();

        return view('AdminSite.Notification.create', $data); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Notification());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id' => $request->id,
                'tgl_notif' => $request->tgl_notif,
                'notification_1' => $request->notification_1,
                'notification_2' => $request->notification_2,
                'notif_image' => $request->notif_image,
                'durasi_notif' => $request->durasi_notif,
                'id_user' => $request->id_user,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Notification ');

            return redirect()->route('notifications.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Notification');

            return redirect()->route('notifications.index');
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
    public function edit(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Notification());
        $user_id = $request->user()->id;
        
        $data['notification'] = $conn->find($id);
        $data['idusers'] =  Login::where('id', $user_id)->get();

        return view('AdminSite.Notification.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Notification());

        $notification = $conn->find($id);
        $notification->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Notification');

        return redirect()->route('notifications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Notification());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Notification');

        return redirect()->route('notifications.index');
    }
}
