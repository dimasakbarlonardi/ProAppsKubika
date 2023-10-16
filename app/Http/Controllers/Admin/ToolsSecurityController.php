<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\ToolsSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Login;


class ToolsSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsSecurity);
        $user_id = $request->user()->id;

        $data['toolsecurity'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ToolsSecurity.index', $data);
    }

    public function borrowToolSecurity(Request $request, $id)
    {
        try {
            // Menghubungkan ke database dan mencari alat berdasarkan ID
            $conn = ConnectionDB::setConnection(new ToolsSecurity());
            $tool = $conn->findOrFail($id); 
            $borrowQty = $request->input('borrow_qty');
        
            // Validasi jumlah peminjaman
            if ($borrowQty <= 0 || $borrowQty > $tool->total_tools - $tool->borrow) {
                Alert::error('error', 'Invalid borrow quantity');
                return redirect()->back();
            }
            
            // Mengambil ID pengguna yang sedang login
            $user_id = $request->user()->id;

            // Memperbarui atribut-atribut alat
            $tool->borrow += $borrowQty;
            $tool->date_out = now();
            $tool->status = 1; // Item masih dipinjam
            $tool->id_user = $user_id;
            $tool->current_totals = $tool->total_tools - $tool->borrow;
            $tool->save();

            Alert::success('success', 'Tool Borrowed successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
        }

    }

    public function returnToolSecurity(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ToolsSecurity());
        $tool = $conn->findOrFail($id);
    
        $returnQty = $request->input('return_qty');
    
        if ($returnQty <= 0 || $returnQty > $tool->borrow) {
            Alert::error('error', 'Invalid return quantity');
            return redirect()->back();
        }

        if ($returnQty > $tool->borrow ) {
            Alert::error('error', 'Invalid return quantity');
            return redirect()->back();
        }
    
        $tool->borrow -= $returnQty;
        if ($tool->borrow == 0) {
            $tool->status = 0; // Item completed
            $tool->date_out = null;
        }
        $tool->save();
    
        // Update current_totals
        $tool->current_totals = $tool->total_tools - $tool->borrow;
        $tool->save();

        Alert::success('success', 'Tool returned successfully');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminSite.ToolsSecurity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conn = ConnectionDB::setConnection(new ToolsSecurity());

        try{
            DB::beginTransaction();
            $conn->create([
                'name_tools' => $request->name_tools,
                'total_tools' => $request->total_tools,
            ]);

            DB::commit();

            Alert::success('Success','Successfully Added Security Tools');

            return redirect()->route('tools-security.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed','Failed to Add Security Tools');

            return redirect()->route('tools-security.index'); 
        }
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
        //
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
