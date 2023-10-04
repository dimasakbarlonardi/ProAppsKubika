<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ToolsHousekeeping;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index($wrID)
    {
        if ($wrID == 12) {
            $connToolsHK = ConnectionDB::setConnection(new ToolsHousekeeping());

            $tools = $connToolsHK->get();

            return ResponseFormatter::success(
                $tools,
                'Success get all house keeping tools'
            );
        }
    }

    public function borrowTool(Request $request, $wrID, $id)
    {
        if ($wrID == 12) {
            $connToolsHK = ConnectionDB::setConnection(new ToolsHousekeeping());
            $tool = $connToolsHK->find($id);
            try {
                $borrowQty = (int) $request->amount;

                if ($borrowQty > $tool->total_tools) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid borrow quantity');
                }

                if ($borrowQty < $tool->total_tools) {
                    // dd($borrowQty, $tool->total_tools);
                    return ResponseFormatter::error([
                        'message' => 'Error1'
                    ], 'Invalid borrow quantity');
                }

                if ($tool->total_tools ==  $tool->borrow) {
                    return ResponseFormatter::error([
                        'message' => 'Error3'
                    ], 'Invalid borrow quantity');
                }

                $user_id = $request->user()->id;
                dd($user_id);
                $tool->borrow += $borrowQty;
                $tool->date_out = now();
                $tool->status = 1; // Item are still on loan
                $tool->id_user = Login::where('id', $user_id)->get(); // Set the user ID as the PIC
                $tool->save();
                // Update current_totals
                $tool->current_totals = $tool->total_tools - $tool->borrow;
                $tool->save();
                Alert::success('success', 'Tool Borrower successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred while borrowing the tool.');
            }

            return ResponseFormatter::success(
                $tool,
                'Success get all house keeping tools'
            );
        }
    }
}
