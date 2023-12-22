<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\IPLType;
use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyIPLMail extends Mailable
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
        $connIPLType = new IPLType();
        $connSetting = $connSetting->setConnection($this->db_name);
        $connIPLType = $connIPLType->setConnection($this->db_name);


        $data['transaction'] = $this->ar;
        $data['setting'] = $connSetting->find(1);
        $data['sc'] = $connIPLType->find(6);
        $data['sf'] = $connIPLType->find(7);
        $data['db_name'] = $this->db_name;
        $data['site'] = Site::where('db_name', $this->db_name)->first();

        return $this->subject('Monthly Utility IPL Periode ' . $this->ar->periode_bulan . '-' . $this->ar->periode_tahun)
            ->view('emails.monthlyIPLBilling', $data);
    }
}
