<?php

namespace App\Http\Controllers\API;

use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\MonthlyUtility;
use App\Models\Tenant;
use App\Models\TenantUnit;
use App\Models\Unit;
use App\Models\Utility;
use Illuminate\Http\Request;
use stdClass;
use Throwable;

class UnitController extends Controller
{
    public function getAllUnits()
    {
        $connUnits = ConnectionDB::setConnection(new Unit());

        $units = $connUnits->get();

        return ResponseFormatter::success(
            $units,
            'Success get all units'
        );
    }

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

            return ResponseFormatter::success(
                $units,
                'Berhasil mengambil units'
            );
        } catch (Throwable $e) {
            return ResponseFormatter::error([
                'message' => 'Tidak ada unit',
                'error' => $e,
            ], 'Tidak ada unit');
        }
    }

    public function getMonthName($month)
    {
        switch ($month) {
            case '01':
                $month = 'January';
                break;
            case '02':
                $month = 'February';
                break;
            case '03':
                $month = 'April';
                break;
            case '04':
                $month = 'March';
                break;
            case '05':
                $month = 'May';
                break;
            case '06':
                $month = 'June';
                break;
            case '07':
                $month = 'July';
                break;
            case '08':
                $month = 'August';
                break;
            case '09':
                $month = 'September';
                break;
            case '10':
                $month = 'October';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'December';
                break;
            default:
                $month = 'Unknown';
        }

        return $month;
    }

    public function waterUsageRecord($unitID)
    {
        $connUtility = ConnectionDB::setConnection(new MonthlyUtility());

        $data = $connUtility
            ->select(['water.id','nomor_air_awal', 'nomor_air_akhir', 'usage', 'water.periode_bulan', 'water.periode_tahun'])
            ->join('tb_eng_monthly_meter_air as water', 'tb_fin_monthly_utility.id_eng_air', '=', 'water.id')
            ->where('tb_fin_monthly_utility.id_unit', $unitID)
            ->orderBy('tb_fin_monthly_utility.id', 'DESC')
            ->get();

        foreach ($data as $item) {
            $item['type'] = 'Water';
            $item['periode_bulan'] = $this->getMonthName($item->periode_bulan);
        }

        return ResponseFormatter::success(
            $data,
            'Success get water usage units'
        );
    }

    public function ShowDetailWaterUsage($id)
    {
        $connMonthlyUtility = ConnectionDB::setConnection(new MonthlyUtility());
        $connUtility = ConnectionDB::setConnection(new Utility());
        $unit = $connMonthlyUtility->where('tb_fin_monthly_utility.id_eng_air', $id)->first();

        $object = new stdClass();
        $object->unit = $unit->Unit->nama_unit;

        $data['detail'] = $connMonthlyUtility
            ->select(['water.id', 'nomor_air_awal', 'nomor_air_akhir', 'usage', 'abodemen', 'total', 'image'])
            ->join('tb_eng_monthly_meter_air as water', 'tb_fin_monthly_utility.id_eng_air', '=', 'water.id')
            ->first();

            $data['biayaWater'] = $connUtility->find(2)
            ->select(['biaya_m3'])
            ->first();

        return ResponseFormatter::success(
            $data,
            $object,
            'Success get water usage units'
        );
    }

    public function electricUsageRecord($unitID)
    {
        $connUtility = ConnectionDB::setConnection(new MonthlyUtility());

        $data = $connUtility
            ->select(['electric.id', 'nomor_listrik_awal', 'nomor_listrik_akhir', 'usage', 'electric.periode_bulan', 'electric.periode_tahun'])
            ->join('tb_eng_monthly_meter_listrik as electric', 'tb_fin_monthly_utility.id_eng_listrik', '=', 'electric.id')
            ->where('tb_fin_monthly_utility.id_unit', $unitID)
            ->orderBy('tb_fin_monthly_utility.id', 'DESC')
            ->get();

        foreach ($data as $item) {
            $item['type'] = 'Electric';
            $item['periode_bulan'] = $this->getMonthName($item->periode_bulan);
        }

        return ResponseFormatter::success(
            $data,
            'Success get water usage units'
        );
    }

    public function ShowDetailElectricUsage($id)
    {
        $connMonthlyUtility = ConnectionDB::setConnection(new MonthlyUtility());
        $connUtility = ConnectionDB::setConnection(new Utility());
        $unit = $connMonthlyUtility->where('tb_fin_monthly_utility.id_eng_listrik', $id)->first();

        $object = new stdClass();
        $object->unit = $unit->Unit->nama_unit;

        $data['detail'] = $connMonthlyUtility
            ->select(['nomor_listrik_awal', 'nomor_listrik_akhir', 'usage', 'electric.id_unit', 'ppj', 'total', 'image'])
            ->join('tb_eng_monthly_meter_listrik as electric', 'tb_fin_monthly_utility.id_eng_listrik', '=', 'electric.id')
            ->first();

        $data['biayaElectric'] = $connUtility->find(1)
            ->select(['biaya_m3'])
            ->first();

        return ResponseFormatter::success(
            $data,
            $object,
            'Success get electric usage units'
        );
    }
}
