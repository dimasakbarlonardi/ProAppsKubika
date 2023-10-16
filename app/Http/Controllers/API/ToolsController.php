<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\ToolHistory;
use App\Models\ToolsEngineering;
use App\Models\ToolsHousekeeping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ToolsController extends Controller
{
    public function index($wrID)
    {
        if ($wrID == 9) {
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
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();

        if ($wrID == 9) {
            $connToolsHK = ConnectionDB::setConnection(new ToolsHousekeeping());

            $tool = $connToolsHK->find($id);

            try {
                DB::beginTransaction();

                $borrowQty = (int) $request->amount;

                if ($borrowQty <= 0 || $borrowQty > ($tool->total_tools - $tool->borrow)) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid borrow quantity');
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

                return ResponseFormatter::success(
                    $tool,
                    'Success borrow tools'
                );
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return ResponseFormatter::error([
                    'message' => 'An error occurred while borrowing the tool.'
                ], 'Invalid return quantity');
            }
        } elseif ($wrID == 8) {

            try {
                // Menghubungkan ke database dan mencari alat berdasarkan ID
                $conn = ConnectionDB::setConnection(new ToolsEngineering());
                $tool = $conn->find($id);
                $borrowQty = (int) $request->amount;

                // Validasi jumlah peminjaman
                if ($borrowQty <= 0 || $borrowQty > ($tool->total_tools - $tool->borrow)) {
                    return ResponseFormatter::error([
                        'message' => 'Error'
                    ], 'Invalid borrow quantity');
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

                return ResponseFormatter::success(
                    $tool,
                    'Success borrow tools'
                );
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                return ResponseFormatter::error([
                    'message' => 'An error occurred while borrowing the tool.'
                ], 'Data not found');
            }
        }
    }

    public function returnTool(Request $request, $wrID, $id)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $connUser = ConnectionDB::setConnection(new User());
        $user = $connUser->where('login_user', $request->user()->email)->first();

        if ($wrID == 9) {
            try {
                DB::beginTransaction();

                $conn = ConnectionDB::setConnection(new ToolsHousekeeping());
                $tool = $conn->find($id);

                $returnQty = (int) $request->amount;

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

                return ResponseFormatter::success(
                    $tool,
                    'Tool returned successfully'
                );
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);

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

            // Update current_totals
            $tool->current_totals = $tool->total_tools - $tool->borrow;
            $tool->save();

            $connToolHistory->create([
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
            dd($countBorrow == $countReturn);
            if ($countBorrow == $countReturn) {
                $status = 'Returned';
            } else {
                $status = 'Still On Borrow';
            }

            $connToolHistory->status = $status;
            $connToolHistory->save();

            return ResponseFormatter::success(
                $tool,
                'Success return tools'
            );
        }
    }

    public function historyTools(Request $request, $wrID, $userID)
    {
        $connToolHistory = ConnectionDB::setConnection(new ToolHistory());
        $histories = $connToolHistory->where('borrowed_by', $userID);
        $site = Site::find($request->user()->id_site);

        if ($wrID == 9) {
            $histories = DB::connection($site->db_name)
                ->table('tb_tools_history as th')
                ->join('tb_tools_housekeeping as eq', 'th.id_data', 'eq.id')
                ->orderBy('th.id', 'DESC')
                ->get();
        } elseif ($wrID == 8) {
            $histories = DB::connection($site->db_name)
                ->table('tb_tools_history as th')
                ->join('tb_tools_engineering as eq', 'th.id_data', 'eq.id')
                ->orderBy('th.id', 'DESC')
                ->get();
        }

        return ResponseFormatter::success(
            $histories,
            'Success return tools'
        );
    }
}
