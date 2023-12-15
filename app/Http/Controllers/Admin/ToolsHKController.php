<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\ToolHistory;
use App\Models\ToolsEngineering;
use App\Models\ToolsHousekeeping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ToolsHKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
        $user_id = $request->user()->id;

        $data['toolshk'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ToolsHK.index', $data);
    }

    public function borrowToolHK(Request $request, $id)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wrID = $user->RoleH->work_relation_id;

        if ($wrID == 9) {
            $connToolsHK = ConnectionDB::setConnection(new ToolsHousekeeping());

            $tool = $connToolsHK->find($id);

            try {
                DB::beginTransaction();

                $borrowQty = (int) $request->borrow_qty;

                if ($borrowQty <= 0 || $borrowQty > ($tool->total_tools - $tool->borrow)) {
                    Alert::error('error', 'Invalid borrow quantity');
                    return redirect()->back();
                }

                // Memperbarui atribut-atribut alat
                $tool->borrow += $borrowQty;
                $tool->date_out = now();
                $tool->status = 1; // Item masih dipinjam
                $tool->current_totals = $tool->total_tools - $tool->borrow;
                $tool->save();

                $connToolHistory->create([
                    'type' => 'HK',
                    'id_data' => $id,
                    'qty' => $borrowQty,
                    'borrowed_by' => $user->id_user,
                    'action' => 'Borrowing',
                    'status' => 'Still On Borrow'
                ]);

                DB::commit();

                Alert::success('success', 'Tool Borrowed successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
            }
        } elseif ($wrID == 8) {
            try {
                // Menghubungkan ke database dan mencari alat berdasarkan ID
                $conn = ConnectionDB::setConnection(new ToolsEngineering());
                $tool = $conn->find($id);
                $borrowQty = (int) $request->borrow_qty;

                // Validasi jumlah peminjaman
                if ($borrowQty <= 0 || $borrowQty > ($tool->total_tools - $tool->borrow)) {
                    dd($borrowQty <= 0, $borrowQty, ($tool->total_tools - $tool->borrow));
                    Alert::error('error', 'Invalid borrow quantity');
                    return redirect()->back();
                }

                // Memperbarui atribut-atribut alat
                $tool->borrow += $borrowQty;
                $tool->date_out = now();
                $tool->status = 1; // Item masih dipinjam
                $tool->current_totals = $tool->total_tools - $tool->borrow;
                $tool->save();

                $connToolHistory->create([
                    'type' => 'ENG',
                    'id_data' => $id,
                    'qty' => $borrowQty,
                    'borrowed_by' => $user->id_user,
                    'action' => 'Borrowing',
                    'status' => 'Still On Borrow'
                ]);

                Alert::success('success', 'Tool Borrowed successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
            }
        }
        Alert::info('info', 'Sorry you dont have permission to borrow tools');
        return redirect()->back();
    }

    public function returnToolHK(Request $request, $id)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wrID = $user->RoleH->work_relation_id;

        if ($wrID == 9) {
            try {
                DB::beginTransaction();

                $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
                $tool = $conn->find($id);

                $returnQty = (int) $request->return_qty;

                if ($returnQty <= 0 || $returnQty > $tool->borrow) {
                    Alert::error('error', 'Invalid borrow quantity');
                    return redirect()->back();
                }

                if ($returnQty > $tool->borrow) {
                    Alert::error('error', 'Invalid borrow quantity');
                    return redirect()->back();
                }

                $tool->borrow -= $returnQty;
                if ($tool->borrow == 0) {
                    $tool->status = 0; // Item completed
                    $tool->date_out = null;
                }

                // Update current_totals
                $tool->current_totals = $tool->total_tools - $tool->borrow;
                $tool->save();

                $createHistory = $connToolHistory->create([
                    'type' => 'HK',
                    'id_data' => $id,
                    'qty' => $returnQty,
                    'action' => 'Returning',
                    'borrowed_by' => $user->id_user
                ]);

                $countBorrow = $connToolHistory->where('borrowed_by', $user->id_user)
                    ->where('action', 'Borrowing')
                    ->sum('qty');
                $countReturn = $connToolHistory->where('borrowed_by', $user->id_user)
                    ->where('action', 'Returning')
                    ->sum('qty');

                if ($countBorrow == $countReturn) {
                    $status = 'Returned';
                } else {
                    $status = 'Still On Borrow';
                }

                $createHistory->status = $status;
                $createHistory->save();

                DB::commit();

                Alert::success('success', 'Tool returned successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);

                Alert::error('error', 'Invalid borrow quantity');
                return redirect()->back();
            }
        } elseif ($wrID == 8) {
            $conn = ConnectionDB::setConnection(new ToolsEngineering());
            $tool = $conn->find($id);

            $returnQty = (int) $request->return_qty;

            if ($returnQty <= 0 || $returnQty > $tool->borrow) {
                Alert::error('error', 'Invalid borrow quantity');
                return redirect()->back();
            }

            if ($returnQty > $tool->borrow) {
                return redirect()->back();
            }

            $tool->borrow -= $returnQty;
            if ($tool->borrow == 0) {
                $tool->status = 0; // Item completed
                $tool->date_out = null;
            }

            // Update current_totals
            $tool->current_totals = $tool->total_tools - $tool->borrow;
            $tool->save();

            $createToolHistory = $connToolHistory->create([
                'type' => 'ENG',
                'id_data' => $id,
                'qty' => $returnQty,
                'action' => 'Returning',
                'borrowed_by' => $user->id_user
            ]);

            $countBorrow = $connToolHistory->where('borrowed_by', $user->id_user)
                ->where('action', 'Borrowing')
                ->sum('qty');
            $countReturn = $connToolHistory->where('borrowed_by', $user->id_user)
                ->where('action', 'Returning')
                ->sum('qty');

            if ($countBorrow == $countReturn) {
                $status = 'Returned';
            } else {
                $status = 'Still On Borrow';
            }

            $createToolHistory->status = $status;
            $createToolHistory->save();

            Alert::success('success', 'Tool returned successfully');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ToolsHK.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());

        try {
            DB::beginTransaction();
            $createTools = $conn->create([
                'name_tools' => $request->name_tools,
                'total_tools' => $request->total_tools,
                'current_totals' => $request->total_tools,
                'unity' => $request->unity
            ]);

            $connToolHistory->create([
                'type' => 'HK',
                'id_data' => $createTools->id,
                'qty' => $request->total_tools,
                'borrowed_by' => $request->session()->get('user')->id_user,
                'action' => 'Create',
                'status' => 'Create Tools'
            ]);

            DB::commit();

            Alert::success('Success', 'Successfully Added HouseKeeping Tools');

            return redirect()->route('toolshousekeeping.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed', 'Failed to Add HouseKeeping Tools');

            return redirect()->route('toolshousekeeping.index');
        }
    }

    public function historyToolHK()
    {
        $connHistories = ConnectionDB::setConnection(new ToolHistory());

        $data['histories'] = $connHistories->where('type', 'HK')->get();

        return view('AdminSite.ToolsHK.history', $data);
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
        //
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
        $connToolsHK = ConnectionDB::setConnection(new ToolsHousekeeping());
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());

        $tool = $connToolsHK->find($id);

        try {
            DB::beginTransaction();

            $editQty = (int) abs($request->total_tools - $tool->total_tools);

            $tool->name_tools = $request->name_tools;
            $tool->total_tools = $request->total_tools;
            $tool->current_totals = $editQty;
            $tool->save();

            $connToolHistory->create([
                'type' => 'HK',
                'id_data' => $id,
                'qty' => $editQty,
                'borrowed_by' => $request->session()->get('user')->id_user,
                'action' => 'Update',
                'status' => 'Update Tools'
            ]);

            DB::commit();

            Alert::success('success', 'Tool Borrowed successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
