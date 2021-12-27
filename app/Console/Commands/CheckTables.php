<?php

namespace App\Console\Commands;

use App\Models\BranchTable;
use Illuminate\Console\Command;

class CheckTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks tables timers';

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
     * @return mixed
     */
    public function handle()
    {
        BranchTable::updateTableTimers();
        $this->info('Checking Tables');
    }
}
