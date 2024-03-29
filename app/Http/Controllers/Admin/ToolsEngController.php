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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ToolsEngController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsEngineering());
        $user_id = $request->user()->id;

        $data['toolsengineer'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ToolsEng.index', $data);
    }

    public function borrowTool(Request $request, $id)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wrID = $user->RoleH->work_relation_id;

        if ($wrID == 8) {
            $connToolsENG = ConnectionDB::setConnection(new ToolsEngineering());

            $tool = $connToolsENG->find($id);

            try {
                DB::beginTransaction();

                $borrowQty = (int) $request->amount;

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
                    'type' => 'ENG',
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
        } elseif ($wrID == 9) {
            try {
                // Menghubungkan ke database dan mencari alat berdasarkan ID
                $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
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
                    'type' => 'HK',
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

    public function returnTool(Request $request, $id)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();
        $wrID = $user->RoleH->work_relation_id;

        if ($wrID == 8) {
            try {
                DB::beginTransaction();

                $conn = ConnectionDB::setConnection(new ToolsEngineering());
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
        } elseif ($wrID == 9) {
            $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
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
        return view('AdminSite.ToolsEng.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsEngineering());
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());

        try {
            DB::beginTransaction();
            $createTools = $conn->create([
                'name_tools' => $request->name_tools,
                'total_tools' => $request->total_tools,
                'current_totals' => $request->total_tools,
                'unity' => $request->unity,
            ]);

            $connToolHistory->create([
                'type' => 'ENG',
                'id_data' => $createTools->id,
                'qty' => $request->total_tools,
                'borrowed_by' => $request->session()->get('user')->id_user,
                'action' => 'Create',
                'status' => 'Create Tools'
            ]);

            DB::commit();

            Alert::success('Berhasi', 'Berhasil Menambahkan Tools Engineering');

            return redirect()->route('toolsengineering.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Gagal', 'Gagal Menambahkan Tools Engineering');

            return redirect()->route('toolsrngineering.index');
        }
    }

    public function historyToolEng()
    {
        $connHistories = ConnectionDB::setConnection(new ToolHistory());

        $data['histories'] = $connHistories->where('type', 'ENG')->get();

        return view('AdminSite.ToolsEng.history', $data);
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
        $connToolsENG = ConnectionDB::setConnection(new ToolsEngineering());
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());

        $tool = $connToolsENG->find($id);

        try {
            DB::beginTransaction();

            $editQty = (int) abs($request->total_tools - $tool->total_tools);

            $tool->name_tools = $request->name_tools;
            $tool->total_tools = $request->total_tools;
            $tool->current_totals = $editQty;
            $tool->save();

            $connToolHistory->create([
                'type' => 'ENG',
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
