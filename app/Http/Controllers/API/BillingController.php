<?php

namespace App\Http\Controllers\API;

use App\Models\Site;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Helpers\ConnectionDB;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ElectricUUS;
use App\Models\MonthlyArTenant;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WaterUUS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Laravel\Sanctum\PersonalAccessToken;
use Midtrans\CoreApi;
use Throwable;

class BillingController extends Controller
{
    public function listBillings(Request $request)
    {
        $dbName = ConnectionDB::getDBname();

        $connARTenant = DB::connection($dbName)
            ->table('tb_fin_monthly_ar_tenant as arm')
            ->where('arm.id_unit', $request->id_unit)
            ->orderBy('periode_bulan', 'desc')
            ->get();

        return ResponseFormatter::success(
            $connARTenant,
            'Authenticated'
        );
    }

    public function showBilling($id)
    {
        $connARTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $ar = $connARTenant->where('id_monthly_ar_tenant', $id);

        $data = $ar->with(['Unit.TenantUnit.Tenant', 'CashReceipt'])
            ->first();

        $previousBills = $ar->first()->PreviousMonthBill();

        return ResponseFormatter::success(
            [
                'current_bill' => $data,
                'previous_bills' => $previousBills
            ],
            'Authenticated'
        );
    }

    public function createTransaction($id)
    {
        $request = Request();
        dd($request, $id);
        $connMonthlyTenant = ConnectionDB::setConnection(new MonthlyArTenant());
        $mt = $connMonthlyTenant->find($id);

        $client = new Client();
        $billing = explode(',', $request->billing);
        $admin_fee = $request->admin_fee;

        if (!$mt->CashReceipt) {
            $transaction = $this->createTransaction($mt);
            if ($billing[0] == 'bank_transfer') {
                $transaction->gross_amount = $transaction->sub_total + $admin_fee;
                $transaction->payment_type = 'bank_transfer';
                $transaction->bank = Str::upper($billing[1]);
                $payment = [];

                $payment['payment_type'] = $billing[0];
                $payment['transaction_details']['order_id'] = $transaction->order_id;
                $payment['transaction_details']['gross_amount'] = $transaction->gross_amount;
                $payment['bank_transfer']['bank'] = $billing[1];

                $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/charge', [
                    'body' => json_encode($payment),
                    'headers' => [
                        'accept' => 'application/json',
                        'authorization' => 'Basic U0ItTWlkLXNlcnZlci1VQkJEOVpMcUdRRFBPd2VpekdkSGFnTFo6',
                        'content-type' => 'application/json',
                    ],
                    "custom_expiry" => [
                        "order_time" => Carbon::now(),
                        "expiry_duration" => 1,
                        "unit" => "day"
                    ]
                ]);
                $response = json_decode($response->getBody());

                $transaction->va_number = $response->va_numbers[0]->va_number;
                $transaction->expiry_time = $response->expiry_time;
                $mt->no_monthly_invoice = $transaction->no_invoice;

                $transaction->admin_fee = $admin_fee;
                $transaction->save();
                $mt->save();

                return redirect()->route('paymentMonthly', [$mt->id_monthly_ar_tenant, $transaction->id]);
            } elseif ($request->billing == 'credit_card') {
                $transaction->payment_type = 'credit_card';
                $transaction->admin_fee = $admin_fee;
                $transaction->gross_amount = round($transaction->sub_total + $admin_fee);

                $getTokenCC = $this->TransactionCC($request);
                $chargeCC = $this->ChargeTransactionCC($getTokenCC->token_id, $transaction);

                $mt->no_monthly_invoice = $transaction->no_invoice;
                $mt->save();

                $transaction->save();

                return redirect($chargeCC->redirect_url);
            }
        } else {
            return redirect()->back();
        }
    }

    public function insertElectricMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);

            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $data['unit'] = $unit;
            $data['token'] = $token;

            return view('AdminSite.UtilityUsageRecording.Electric.create', $data);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function storeElectricMeter(Request $request, $unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $login = $tokenable->tokenable;
            $site = Site::find($login->id_site);

            $user = new User();
            $user = $user->setConnection($site->db_name);
            $user = $user->where('login_user', $login->email)->first();

            $connElecUUS = new ElectricUUS();
            $connElecUUS = $connElecUUS->setConnection($site->db_name);

            $connElecUUS->firstOrCreate(
                [
                    'periode_bulan' => $request->periode_bulan,
                    'periode_tahun' => Carbon::now()->format('Y')
                ],
                [
                    'periode_bulan' => $request->periode_bulan,
                    'periode_tahun' => Carbon::now()->format('Y'),
                    'id_unit' => $unitID,
                    'nomor_listrik_awal' => $request->previous,
                    'nomor_listrik_akhir' => $request->current,
                    'usage' => $request->current - $request->previous,
                    'id_user' => $user->id_user
                ]
            );

            Alert::success('Berhasil', 'Berhasil menambahkan data');

            return redirect()->back();
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function insertWaterMeter($unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            $user = $tokenable->tokenable;
            $site = Site::find($user->id_site);
            $connUnit = new Unit();
            $connUnit = $connUnit->setConnection($site->db_name);
            $unit = $connUnit->find($unitID);

            $data['unit'] = $unit;
            $data['token'] = $token;

            return view('AdminSite.UtilityUsageRecording.Water.create', $data);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function storeWaterMeter(Request $request, $unitID, $token)
    {
        $getToken = str_replace("RA164-", "|", $token);
        $tokenable = PersonalAccessToken::findToken($getToken);

        if ($tokenable) {
            try {
                DB::beginTransaction();
                $login = $tokenable->tokenable;
                $site = Site::find($login->id_site);

                $user = new User();
                $user = $user->setConnection($site->db_name);
                $user = $user->where('login_user', $login->email)->first();

                $connWaterUUS = new WaterUUS();
                $connWaterUUS = $connWaterUUS->setConnection($site->db_name);

                $connWaterUUS->firstOrCreate([
                    'periode_bulan' => $request->periode_bulan,
                    'periode_tahun' => Carbon::now()->format('Y'),
                ], [
                    'periode_bulan' => $request->periode_bulan,
                    'periode_tahun' => Carbon::now()->format('Y'),
                    'id_unit' => $unitID,
                    'nomor_air_awal' => $request->previous,
                    'nomor_air_akhir' => $request->current,
                    'usage' => $request->current - $request->previous,
                    'id_user' => $user->id_user
                ]);

                Alert::success('Berhasil', 'Berhasil menambahkan data');

                return redirect()->back();
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                dd($e);
                Alert::error('Gagal', 'Gagal menambahkan data');

                return redirect()->back();
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function getTokenCC(Request $req)
    {
        $login = $req->user();
        $site = Site::find($login->id_site);

        try {
            $token = CoreApi::cardToken(
                $req->card_number,
                $req->card_exp_month,
                $req->card_exp_year,
                $req->card_cvv,
                $site->midtrans_client_key
            );

            if ($token->status_code != 200) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 401);
            }

            return ResponseFormatter::success([
                $token
            ], 'Authenticated');
        } catch (\Throwable $e) {
            dd($e);
            return ResponseFormatter::error([
                'message' => 'Internar Error'
            ], 'Something went wrong', 500);
        }

        return response()->json(['token' => $token]);
    }
}
