<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;
use Throwable;

class SiteController extends Controller
{
    public function index()
    {
        $data['sites'] = Site::with('pengurus.group')->get();

        return view('Admin.Site.index', $data);
    }

    public function create()
    {
        $data['penguruses'] = Pengurus::all();

        return view('Admin.Site.create', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Site::create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan site');

            return redirect()->route('sites.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function edit(Site $site)
    {
        $data['site'] = $site;
        $data['penguruses'] = Pengurus::all();

        return view('Admin.Site.edit', $data);
    }

    public function update(Request $request, Site $site)
    {
        try {
            DB::beginTransaction();

            $site->update($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil mengubah site');

            return redirect()->route('sites.index');
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function destroy(Site $site)
    {
        $site->delete();

        Alert::success('Berhasil', 'Berhasil mengubah site');

        return redirect()->route('sites.index');
    }
}
