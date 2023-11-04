<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\FCM as FcmNotification;
use App\Models\Login;


class FCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fcm {--token=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $login = Login::where('email', 'engineering@mail.com')->first();


        $notif = new FcmNotification();
        $notif->setPayload([
            'title' => 'Test Notif',
            'body' => 'ini test body',
            'token' => $login->fcm_token,
        ])->send();

        return 0;
    }
}
