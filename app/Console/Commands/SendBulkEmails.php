<?php

namespace App\Console\Commands;

use App\Jobs\SendBulkEmailJob;
use Illuminate\Console\Command;

class SendBulkEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-bulk-emails';

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
        $emails = [
            ['email' => 'akmalrifqi2013@gmail.com'],
            ['email' => 'ragamuthahari@gmail.com'],
            ['email' => 'dimas.akbar.lonardi@gmail.com'],
            ['email' => 'rsantoso.me@gmail.com'],
        ];

        $data['emails'] = $emails;

        SendBulkEmailJob::dispatch($data);
    }
}
