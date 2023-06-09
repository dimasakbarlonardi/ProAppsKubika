<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReminderLetter;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\ConnectionDB;
use Illuminate\Http\Request;

class ReminderLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new ReminderLetter());

        $data ['reminders'] = $conn->get();

        return view('AdminSite.ReminderLetter.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ReminderLetter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ReminderLetter());

        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_reminder_letter' => $request->id_reminder_letter,
                'reminder_letter' => $request->reminder_letter,
                'durasi_reminder_letter' => $request->durasi_reminder_letter,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Reminder Letter ');

            return redirect()->route('reminders.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Reminder Letter');

            return redirect()->route('reminders.index');
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
        $conn = ConnectionDB::setConnection(new ReminderLetter());

        $data['reminder'] = $conn->find($id);

        return view('AdminSite.ReminderLetter.edit', $data);
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
        $conn = ConnectionDB::setConnection(new ReminderLetter());

        $reminder = $conn->find($id);
        $reminder->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Reminder Letter');

        return redirect()->route('reminders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new ReminderLetter());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Reminder Letter');

        return redirect()->route('reminders.index');
    }
}
