<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\SubMenu2;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class   SubMenuController extends Controller
{
    public function createSubMenu($id)
    {
        $data['id'] = $id;

        return view('Admin.SubMenu.create', $data);
    }

    public function store(Request $request)
    {
        $menu = SubMenu::create($request->all());

        Alert::success('Berhasil', 'Berhasil menambahkan menu');

        return redirect()->route('menus.show', $menu->parent_id);
    }

    public function show($id)
    {
        $data['submenus'] = SubMenu2::where('parent_id', $id)->get();
        $data['id'] = $id;

        return view('Admin.SubMenu2.create', $data);
    }
}
