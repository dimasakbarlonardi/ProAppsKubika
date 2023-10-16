<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Login;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Notification;

class AgamaController extends Controller
{
    public function notification()
    {
        return view('notification');
    }

    public function testFCM(Request $request)
    {
        try {
            $fcmTokens = Login::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            $SERVER_API_KEY = env("FIREBASE_SERVER_KEY", null);

            $data = [
                "registration_ids" => $fcmTokens,
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->body,
                    "content_available" => true,
                    "priority" => "high",
                ]
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            return response()->json($response);

        } catch (\Exception $e) {
            report($e);
            return redirect()->back();
        }
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['fcm_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Agama());

        $data['agamas'] = $conn->get();

        return view('AdminSite.Agama.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.Agama.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new Agama());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan agama');

            return redirect()->route('agamas.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan agama');

            return redirect()->route('agamas.index');
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
        $conn = ConnectionDB::setConnection(new Agama());

        $data['agama'] = $conn->where('id_agama', $id)->first();

        return view('AdminSite.Agama.edit', $data);
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
        $conn = ConnectionDB::setConnection(new Agama());

        $agama = $conn->find($id);

        $agama->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate agama');

        return redirect()->route('agamas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new Agama());

        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus agama');

        return redirect()->route('agamas.index');
    }
}
