<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantUnit;
use Illuminate\Http\Request;
use Throwable;

class UnitController extends Controller
{
    public function tenantUnit(Request $request)
    {
        try {
            $connTenant = ConnectionDB::setConnection(new Tenant());
            $connTU = ConnectionDB::setConnection(new TenantUnit());

            $user = $request->user();
            $getTenant = $connTenant->where('email_tenant', $user->email)->first();

            $units = $connTU->where('id_tenant', $getTenant->id_tenant)
            ->with('Unit')
            ->get();

            return ResponseFormatter::success([
                'units' => $units
            ], 'Berhasil mengambil units');
        } catch(Throwable $e) {
            return ResponseFormatter::error([
                'message' => 'Tidak ada unit',
                'error' => $e,
            ], 'Tidak ada unit');
        }
    }
}
