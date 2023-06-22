<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\FinReminderLetter;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class FinMonthlyReminderLetter extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conn = ConnectionDB::setConnection(new FinReminderLetter());

        $data['finmonthlyreminderletters'] = $conn->get();

        return view('AdminSite.FinMonthlyReminderLetter.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.FinMonthlyReminderLetter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new FinReminderLetter());
        try {
            
            DB::beginTransaction();

            $conn->create([
                'id_fin_reminder_letter' => $request->id_fin_reminder_letter,
                'no_monthly_invoice' => $request->no_monthly_invoice,
                'no_reminder_letter' => $request->no_reminder_letter,
                'tgl_reminder_letter' => $request->tgl_reminder_letter
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan Monthly Reminder Letter');

            return redirect()->route('finmonthlyreminderletter.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan Monthly Reminder Letter');

            return redirect()->route('finmonthlyreminderletter.index');
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
        $conn = ConnectionDB::setConnection(new FinReminderLetter());

        $data['finmonthlyreminderletter'] = $conn->find($id);

        return view('AdminSite.FinMonthlyReminderLetter.edit', $data);
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
        $conn = ConnectionDB::setConnection(new FinReminderLetter());

        $reminderletter = $conn->find($id);
        $reminderletter->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate Monthly Reminder Letter');

        return redirect()->route('finmonthlyreminderletters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conn = ConnectionDB::setConnection(new FinReminderLetter());

        $conn->find($id)->delete();
        Alert::success('Berhasil','Berhasil Menghapus Monthly Reminder Letter');

        return redirect()->route('finmonthlyreminderletters.index');
    }
}
