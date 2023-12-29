<?php

namespace App\Mail;

use App\Helpers\ConnectionDB;
use App\Models\CompanySetting;
use App\Models\MonthlyArTenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlySplittedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $id_unit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id_unit)
    {
        $this->id_unit = $id_unit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $connSetting = ConnectionDB::setConnection(new CompanySetting());
        $connAR = ConnectionDB::setConnection(new MonthlyArTenant());

        $data['transaction'] = $connAR->where('id_unit', $this->id_unit)->where('status_payment', 'UNPAID')->get();

        $data['setting'] = $connSetting->find(1);

        return $this->subject('Mail from akmal rifqi')
            ->view('emails.monthlySplittedBilling', $data);
    }
}
