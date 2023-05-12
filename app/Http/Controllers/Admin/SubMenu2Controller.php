<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubMenu2;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubMenu2Controller extends Controller
{
    public function create($id)
    {
        $data['id'] = $id;

        return view('Admin.SubMenu2.create', $data);
    }

    public function show($id)
    {
        $data['submenus'] = SubMenu2::where('parent_id', $id)->get();
        $data['id'] = $id;

        return view('Admin.SubMenu2.index', $data);
    }

    public function store(Request $request)
    {
        $menu = SubMenu2::create($request->all());

        Alert::success('Berhasil', 'Berhasil menambahkan menu');

        return redirect()->route('sub-menus-2.show', $menu->parent_id);
    }
}
