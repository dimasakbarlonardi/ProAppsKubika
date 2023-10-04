<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ToolsEngineering;
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
        } elseif ($wrID == 8) {
            $connToolsEng = ConnectionDB::setConnection(new ToolsEngineering());

            $tools = $connToolsEng->get();

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

                if ($borrowQty <= 0 || $borrowQty > $tool->total_tools - $tool->borrow) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid borrow quantity');
                }

                $user_id = $request->user()->id;

                // Memperbarui atribut-atribut alat
                $tool->borrow += $borrowQty;
                $tool->date_out = now();
                $tool->status = 1; // Item masih dipinjam
                $tool->id_user = $user_id;
                $tool->current_totals = $tool->total_tools - $tool->borrow;
                $tool->save();

                return ResponseFormatter::success(
                    $tool,
                    'Success borrow tools'
                );
            } catch (\Exception $e) {
                return ResponseFormatter::error([
                    'message' => 'An error occurred while borrowing the tool.'
                ], 'Invalid return quantity');
            }
        } elseif ($wrID == 8) {
            try {
                // Menghubungkan ke database dan mencari alat berdasarkan ID
                $conn = ConnectionDB::setConnection(new ToolsEngineering());
                $tool = $conn->find($id);
                $borrowQty = $request->amount;

                // Validasi jumlah peminjaman
                if ($borrowQty <= 0 || $borrowQty > $tool->total_tools - $tool->borrow) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid borrow quantity');
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

                return ResponseFormatter::success(
                    $tool,
                    'Success borrow tools'
                );
            } catch (\Exception $e) {
                return ResponseFormatter::error([
                    'message' => 'An error occurred while borrowing the tool.'
                ], 'Data not found');
            }
        }
    }

    public function returnTool(Request $request, $wrID, $id)
    {
        if ($wrID == 12) {
            try {
                $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
                $tool = $conn->find($id);

                $returnQty = $request->amount;

                if ($returnQty <= 0 || $returnQty > $tool->borrow) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid return quantity');
                }

                if ($returnQty > $tool->borrow) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid return quantity');
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

                return ResponseFormatter::success(
                    $tool,
                    'Tool returned successfully'
                );
            } catch (\Exception $e) {
                return ResponseFormatter::error([
                    'message' => 'An error occurred while borrowing the tool.'
                ], 'Invalid return quantity');
            }
        } elseif ($wrID == 8) {
            $conn = ConnectionDB::setConnection(new ToolsEngineering());
            $tool = $conn->find($id);

            $returnQty = $request->amount;

            if ($returnQty <= 0 || $returnQty > $tool->borrow) {
                return ResponseFormatter::error([
                    'message' => 'Error'
                ], 'Invalid borrow quantity');
            }

            if ($returnQty > $tool->borrow) {
                return ResponseFormatter::error([
                    'message' => 'Error'
                ], 'Invalid borrow quantity');
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

            return ResponseFormatter::success(
                $tool,
                'Success return tools'
            );
        }
    }
}
