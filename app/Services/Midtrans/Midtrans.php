<?php

namespace App\Services\Midtrans;

use App\Models\Site;
use Midtrans\Config;

class Midtrans {
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        $this->_configureMidtrans();
    }

    public function _configureMidtrans()
    {
        $request = Request();
        $user = $request->session()->get('user');
        if ($user) {
            $site = Site::find($user->id_site);
        } else {
            $siteID = substr($request->order_id, 0, 6);
            $site = Site::find($siteID);
        }
        Config::$serverKey = $site->midtrans_server_key;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }
}
