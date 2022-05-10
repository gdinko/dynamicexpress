<?php

namespace Gdinko\DynamicExpress\Commands;

use Illuminate\Console\Command;

class SyncCarrierDynamicExpressAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:sync-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync All Dynamic Express nomenclatures';

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
        $this->call('dynamic-express:sync-countries');

        $this->call('dynamic-express:sync-cities');

        $this->call('dynamic-express:sync-offices');

        return 0;
    }
}
