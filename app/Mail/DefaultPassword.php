<?php

namespace App\Mail;

use App\Helpers\ConnectionDB;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DefaultPassword extends Mailable
{
    use Queueable, SerializesModels;
    protected $idAR, $db_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['tenant'] = $this->tenant;
      
        return $this->subject('Blast Email Password')
            ->view('emails.DefaultPassword', $data);
    }
}
