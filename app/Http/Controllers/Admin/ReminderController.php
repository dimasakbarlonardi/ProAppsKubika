<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\WorkRelation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReminderController extends Controller
{
    public function index()
    {
        $conn = ConnectionDB::setConnection(new Reminder());

        $data['reminders'] = $conn->get();

        return view('AdminSite.Reminders.index', $data);
    }

    public function create()
    {
        $connWorkRelations = ConnectionDB::setConnection(new WorkRelation());

        $data['work_relations'] = $connWorkRelations->get();

        return view('AdminSite.Reminders.create', $data);
    }

    public function store(Request $request)
    {
        $connReminder = ConnectionDB::setConnection(new Reminder());

        $connReminder->create($request->all());

        Alert::success('Success', 'Success add reminder');

        return redirect()->route('reminders.index');
    }

    public function show($id)
    {
        $connReminder = ConnectionDB::setConnection(new Reminder());

        $data['reminder'] = $connReminder->find($id);

        return view('AdminSite.Reminders.show', $data);
    }
}
