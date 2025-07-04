<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SampleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sample-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sample Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo 'サンプルコマンドです';
        return 0;
    }
}
