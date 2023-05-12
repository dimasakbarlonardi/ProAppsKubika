<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuHeading;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MenuHeadingController extends Controller
{
    public function index()
    {
        $data['menus'] = MenuHeading::all();

        return view('Admin.MenuHeading.index', $data);
    }

    public function create()
    {
        return view('Admin.MenuHeading.create');
    }

    public function store(Request $request)
    {
        MenuHeading::create($request->all());

        Alert::success('Berhasil', 'Berhasil menambahkan menu');

        return redirect()->route('menu-headings.index');
    }

    public function show($id)
    {
        $data['menus'] = Menu::where('heading_id', $id)->get();
        $data['id'] = $id;

        return view('Admin.Menu.index', $data);
    }
}
