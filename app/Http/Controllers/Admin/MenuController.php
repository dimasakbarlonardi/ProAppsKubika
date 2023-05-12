<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuHeading;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function index()
    {
        $data['menus'] = Menu::all();

        return view('Admin.Menu.index', $data);
    }

    public function createMenu($id)
    {
        $data['id'] = $id;

        return view('Admin.Menu.create', $data);
    }

    public function store(Request $request)
    {
        $menu = Menu::create($request->all());

        Alert::success('Berhasil', 'Berhasil menambahkan menu');

        return redirect()->route('menu-headings.show', $menu->heading_id);
    }

    public function show($id)
    {
        $data['submenus'] = SubMenu::where('parent_id', $id)->get();
        $data['id'] = $id;

        return view('Admin.SubMenu.index', $data);
    }
}
