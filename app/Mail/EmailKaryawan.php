<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailKaryawan extends Mailable
{
    use Queueable, SerializesModels;
    protected $idAR, $db_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($karyawan)
    {
        $this->karyawan = $karyawan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['karyawan'] = $this->karyawan;
        return $this->subject('Blast Email Karyawan')->view('emails.EmailKaryawan', $data);

    }
}
