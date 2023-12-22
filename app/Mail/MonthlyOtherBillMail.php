<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyOtherBillMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $idAR, $db_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ar, $db_name)
    {
        $this->ar = $ar;
        $this->db_name = $db_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $connSetting = new CompanySetting();
        $connSetting = $connSetting->setConnection($this->db_name);

        $data['transaction'] = $this->ar;
        $data['setting'] = $connSetting->find(1);
        $data['db_name'] = $this->db_name;
        $data['site'] = Site::where('db_name', $this->db_name)->first();

        return $this->subject('Monthly Other Billing Periode ' . $this->ar->periode_bulan . '-' . $this->ar->periode_tahun)
            ->view('emails.monthlyOtherBilling', $data);
    }
}
