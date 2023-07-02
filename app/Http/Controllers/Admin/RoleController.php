<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\AksesForm;
use App\Models\Login;
use App\Models\Menu;
use App\Models\MenuHeading;
use App\Models\Role;
use App\Models\SubMenu;
use App\Models\SubMenu2;
use App\Models\User;
use App\Models\WorkRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function setConnection($model)
    {
        $request = Request();
        $user_id = $request->user()->id;
        $login = Login::where('id', $user_id)->with('site')->first();
        $conn = $login->site->db_name;
        $model = $model;
        $model->setConnection($conn);

        return $model;
    }

    public function pushHeadings($role_id)
    {
        $headings = [];

        $aksesForm = $this->setConnection(new AksesForm());
        $getHeadings = $aksesForm->where('role_id', $role_id)
            ->where('menu_category', 'menus')
            ->get();

        foreach ($getHeadings as $nav) {
            $headings[] = $nav->heading;
        }

        return $headings;
    }

    public function pushMenus($role_id)
    {
        $menus = [];

        $aksesForm = $this->setConnection(new AksesForm());
        $getMenus = $aksesForm->where('role_id', $role_id)
            ->where('menu_category', 'menus')
            ->get();

        foreach ($getMenus as $menu) {
            $menus[] = $menu->menu_id;
        }

        return $menus;
    }

    public function pushSubMenus($role_id)
    {
        $subMenus = [];

        $aksesForm = $this->setConnection(new AksesForm());
        $getSubMenus = $aksesForm->where('role_id', $role_id)
            ->where('menu_category', 'sub_menus')
            ->get();

        foreach ($getSubMenus as $subMenu) {
            $subMenus[] = $subMenu->menu_id;
        }

        return $subMenus;
    }

    public function pushSubMenus2($role_id)
    {
        $subMenus2 = [];

        $aksesForm = $this->setConnection(new AksesForm());
        $getSubMenus2 = $aksesForm->where('role_id', $role_id)
            ->where('menu_category', 'sub_menus2')
            ->get();

        foreach ($getSubMenus2 as $subMenu2) {
            $subMenus2[] = $subMenu2->menu_id;
        }

        return $subMenus2;
    }

    public function index()
    {
        $conn = $this->setConnection(new Role());

        $data['roles'] = $conn->get();

        return view('AdminSite.Role.index', $data);
    }

    public function create()
    {
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $data['work_relations'] = $connWorkRelation->get();

        return view('AdminSite.Role.create', $data);
    }

    public function store(Request $request)
    {
        $conn = $this->setConnection(new Role());

        try {
            DB::beginTransaction();

            $conn->create($request->all());

            DB::commit();

            Alert::success('Berhasil', 'Berhasil menambahkan role');

            return redirect()->route('roles.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::error('Gagal', 'Gagal menambahkan role');

            return redirect()->route('roles.index');
        }
    }

    public function destroy($id)
    {
        $conn = $this->setConnection(new Role());
        $conn->find($id)->delete();

        Alert::success('Berhasil', 'Berhasil menghapus role');

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $conn = $this->setConnection(new Role());
        $connWorkRelation = ConnectionDB::setConnection(new WorkRelation());

        $data['role'] = $conn->find($id);
        $data['work_relations'] = $connWorkRelation->get();

        return view('AdminSite.Role.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $conn = $this->setConnection(new Role());

        $role = $conn->find($id);
        $role->update($request->all());

        Alert::success('Berhasil', 'Berhasil mengupdate role');

        return redirect()->route('roles.index');
    }

    public function aksesForm($role_id)
    {
        $data['menus'] = Menu::with('subMenus.subMenus2')->get();

        $getMenus = $this->pushMenus($role_id);
        $getSubMenus = $this->pushSubMenus($role_id);
        $getSubMenus2 = $this->pushSubMenus2($role_id);

        $data['selected_menus'] = Menu::with(['subMenus' => function ($q) use ($getSubMenus, $getSubMenus2) {
            $q->whereIn('id', $getSubMenus)
                ->with(['subMenus2' => function ($q) use ($getSubMenus2) {
                    $q->whereIn('id', $getSubMenus2);
                }]);
        }])
            ->whereIn('id', $getMenus)
            ->get();

        return view('AdminSite.AksesForm.index', $data);
    }

    public function aksesFormStore($aksesForm, $kodeForm, $menuID, $cat, $heading, $role_id)
    {
        $aksesForm->where('kode_form', $kodeForm)->firstOrCreate([
            'kode_form' => $kodeForm,
            'menu_id' => $menuID,
            'menu_category' => $cat,
            'role_id' => $role_id,
            'heading' => $heading
        ]);
    }

    public function storeAksesForm(Request $request, $role_id)
    {
        $takeForms = $request->to;
        $aksesForm = $this->setConnection(new AksesForm());

        $kodeFormArray = [];
        $menuCatArray = [];
        $menuIDArray = [];

        if (isset($takeForms)) {
            foreach ($takeForms as $form) {
                $kode_form = explode("|", $form);
                $kodeFormArray[] = $kode_form[1];
                $menuCatArray[] = $kode_form[0];
                $menuIDArray[] = $kode_form[2];
            }

            $deletes = $aksesForm->where('role_id', $role_id)
                ->whereNotIn('kode_form', $kodeFormArray)
                ->get();

            if (count($deletes) > 0) {
                $aksesForm->where('role_id', $role_id)
                    ->whereNotIn('kode_form', $kodeFormArray)
                    ->delete();
            } else {
                foreach ($request->to as $data) {

                    $get_req = explode("|", $data);
                    $menu_id = $get_req[2];

                    if ($get_req[0] == 'sub_menus2') {
                        $submenu2 = SubMenu2::where('id', $menu_id)
                            ->with('subMenu.menu')->first();

                        $this->aksesFormStore(
                            $aksesForm,
                            $submenu2->subMenu->menu->kode_form,
                            $submenu2->subMenu->menu->id,
                            'menus',
                            $submenu2->subMenu->menu->heading_id,
                            $role_id
                        );

                        $this->aksesFormStore(
                            $aksesForm,
                            $submenu2->subMenu->kode_form,
                            $submenu2->subMenu->id,
                            'sub_menus',
                            $submenu2->subMenu->menu->heading_id,
                            $role_id
                        );

                        $this->aksesFormStore(
                            $aksesForm,
                            $submenu2->kode_form,
                            $submenu2->id,
                            'sub_menus2',
                            $submenu2->subMenu->menu->heading_id,
                            $role_id
                        );
                    }

                    if ($get_req[0] == 'sub_menus') {

                        $submenu = SubMenu::where('id', $menu_id)
                            ->with('menu')->first();

                        $this->aksesFormStore(
                            $aksesForm,
                            $submenu->menu->kode_form,
                            $submenu->menu->id,
                            'menus',
                            $submenu->menu->heading_id,
                            $role_id
                        );

                        $this->aksesFormStore(
                            $aksesForm,
                            $submenu->kode_form,
                            $submenu->id,
                            'sub_menus',
                            $submenu->menu->heading_id,
                            $role_id
                        );
                    }

                    if ($get_req[0] == 'menus') {
                        $menu = Menu::where('id', $menu_id)->first();

                        $this->aksesFormStore(
                            $aksesForm,
                            $menu->kode_form,
                            $menu->id,
                            'menus',
                            $menu->heading_id,
                            $role_id
                        );
                    }
                }
            }
        } else {
            $aksesForm->where('role_id', $role_id)
                ->whereNotIn('kode_form', $kodeFormArray)
                ->get();
        }


        return redirect()->back();
    }

    public function checkRoleID(Request $request)
    {
        $role_id = $request->session()->get('has_role');

        return $role_id;
    }

    public function getMenu($role_id)
    {
        $getHeadings = $this->pushHeadings($role_id);
        $getMenus = $this->pushMenus($role_id);
        $getSubMenus = $this->pushSubMenus($role_id);
        $getSubMenus2 = $this->pushSubMenus2($role_id);

        $data_nav = MenuHeading::with(['menus' => function ($q) use ($getMenus, $getSubMenus, $getSubMenus2) {
            return $q->whereIn('id', $getMenus)
                ->with(['subMenus' => function ($q) use ($getSubMenus, $getSubMenus2) {
                    $q->whereIn('id', $getSubMenus)
                        ->with(['subMenus2' => function ($q) use ($getSubMenus2) {
                            $q->whereIn('id', $getSubMenus2);
                        }]);
                }]);
        }])
            ->whereIn('id', $getHeadings)
            ->get();

        return $data_nav;
    }

    public function getNavByRole(Request $request, $id)
    {
        $user = $this->setConnection(new User());
        $user = $user->find($id);
        $role_id = $user->id_role_hdr;

        $data_nav = $this->getMenu($role_id);

        $request->session()->put('side-navigation', $data_nav);

        return response()->json([
            'html' => view('layouts.side-navigation')->render(),
        ]);
    }
}
