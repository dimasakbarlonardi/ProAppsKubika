<?php

namespace App\Http\Controllers\Admin;

use File;
use App\Helpers\SaveFile;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AnnouncementController extends Controller
{
    public function index()
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $data['announcements'] = $connNotif->where('type', 'Announcement')->get();

        return view('AdminSite.Announcement.index', $data);
    }

    public function create()
    {
        return view('AdminSite.Announcement.create');
    }

    public function store(Request $request)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $connNotif->sender = $request->session()->get('user')->id_user;
        $connNotif->notif_title = $request->notif_title;
        $connNotif->notif_message = $request->notif_message;
        $connNotif->type = 'Announcement';

        $photo = $request->file('photo');
        if ($photo) {
            $fileName = 'announcement' . '-' . Carbon::now()->format('Y-m-d') . '-' .   $photo->getClientOriginalName();
            $path = '/public/' . $request->session()->get('user')->id_site . '/img/' . 'announcement' . '/' . $fileName;
            $storagePath = '/storage/' . $request->session()->get('user')->id_site . '/img/' . 'announcement' .  '/' . $fileName;

            Storage::disk('local')->put($path, File::get($photo));
            $connNotif->photo = $storagePath;
        }
        $file = $request->file('file');
        if ($file) {
            $fileName2 = 'announcement' . '-' . Carbon::now()->format('Y-m-d') . '-' .   $file->getClientOriginalName();
            $path2 = '/public/' . $request->session()->get('user')->id_site . '/file/' . 'announcement' . '/' . $fileName2;
            $storagePath2 = '/storage/' . $request->session()->get('user')->id_site . '/file/' . 'announcement' .  '/' . $fileName2;

            Storage::disk('local')->put($path2, File::get($file));
            $connNotif->file = $storagePath2;
        }

        $connNotif->save();

        Alert::success('Success', 'Success create announcement');

        return redirect()->route('announcements.index');
    }
}
