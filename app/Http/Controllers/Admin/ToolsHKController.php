<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ConnectionDB;
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\ToolsHousekeeping;
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

        $data ['toolshk'] = $conn->get();
        $data['idusers'] = Login::where('id', $user_id)->get();

        return view('AdminSite.ToolsHK.index', $data);
    }

     public function borrowToolHK(Request $request, $id)
    {
        try {
            $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
            $tool = $conn->findOrFail($id);
            $borrowQty = $request->input('borrow_qty');
        
            if ($borrowQty <= 0 || $borrowQty > ($tool->total_tools - $tool->borrow)) {
                return redirect()->back()->with('error', 'Invalid borrow quantity');
            }
            
            $user_id = $request->user()->id;
            $tool->borrow += $borrowQty;
            $tool->date_out = now();
            $tool->status = 1; // Item are still on loan
            $tool->id_user = Login::where('id', $user_id)->get(); // Set the user ID as the PIC
            $tool->save();
            // Update current_totals
            $tool->current_totals = $tool->total_tools - $tool->borrow;
            $tool->save();
        
            return redirect()->route('toolshousekeeping.index')->with('success', 'Tool borrowed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
        }
    }

    public function returnToolHK(Request $request, $id)
    {
        $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
        $tool = $conn->findOrFail($id);
    
        $returnQty = $request->input('return_qty');
    
        if ($returnQty <= 0 || $returnQty > $tool->borrow) {
            return redirect()->back()->with('error', 'Invalid return quantity');
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
    
        return redirect()->route('toolshousekeeping.index')->with('success', 'Tool returned successfully');
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

        try{
            DB::beginTransaction();
            $conn->create([
                'name_tools' => $request->name_tools,
                'total_tools' => $request->total_tools,
            ]);

            DB::commit();

            Alert::success('Success','Successfully Added HouseKeeping Tools');

            return redirect()->route('toolshousekeeping.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            Alert::success('Failed','Failed to Add HouseKeeping Tools');

            return redirect()->route('toolshousekeeping.index'); 
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