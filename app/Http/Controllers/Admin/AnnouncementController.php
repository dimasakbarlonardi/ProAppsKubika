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

        // Mengasumsikan Anda ingin mendapatkan pengumuman pertama untuk diedit
        $data['edit'] = $connNotif->where('type', 'Announcement')->first();

        return view('AdminSite.Announcement.index', $data);
    }

    public function create()
    {
        return view('AdminSite.Announcement.create');
    }

    public function edit($id)
    {
        $connNotif = ConnectionDB::setConnection(new Notifikasi());

        $data['announcements'] = $connNotif->where('type', 'Announcement')->find($id);

        return view('AdminSite.Announcement.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new Notifikasi());

        $announcements = $conn->where('type', 'Announcement')->find($id);
        $announcements->update($request->all());

        // Proses untuk mengupdate foto
        $photo = $request->file('photo');
        if ($photo) {
            $fileName = 'announcement' . '-' . Carbon::now()->format('Y-m-d') . '-' .   $photo->getClientOriginalName();
            $path = '/public/' . $request->session()->get('user')->id_site . '/img/' . 'announcement' . '/' . $fileName;
            $storagePath = '/storage/' . $request->session()->get('user')->id_site . '/img/' . 'announcement' .  '/' . $fileName;

            Storage::disk('local')->put($path, File::get($photo));
            $announcements->photo = $storagePath;
        }

        // Proses untuk mengupdate file
        $file = $request->file('file');
        if ($file) {
            $fileName2 = 'announcement' . '-' . Carbon::now()->format('Y-m-d') . '-' .   $file->getClientOriginalName();
            $path2 = '/public/' . $request->session()->get('user')->id_site . '/file/' . 'announcement' . '/' . $fileName2;
            $storagePath2 = '/storage/' . $request->session()->get('user')->id_site . '/file/' . 'announcement' .  '/' . $fileName2;

            Storage::disk('local')->put($path2, File::get($file));
            $announcements->file = $storagePath2;
        }

        $announcements->save();

        Alert::success('Berhasil', 'Berhasil mengupdate Announcement');

        return redirect()->route('announcements.index');
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
