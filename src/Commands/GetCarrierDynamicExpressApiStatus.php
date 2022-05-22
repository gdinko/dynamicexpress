<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressApiStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GetCarrierDynamicExpressApiStatus extends Command
{
    public const API_STATUS_OK = 200;
    public const API_STATUS_NOT_OK = 404;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:api-status
                            {--clear= : Clear Database table from records older than X days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express API Status and saves it in database';

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
        $this->info('-> Carrier Dynamic Express Api Status');

        try {
            $this->clear();

            $countries = DynamicExpress::getCountries();

            if (!empty($countries)) {
                CarrierDynamicExpressApiStatus::create([
                    'code' => self::API_STATUS_OK,
                ]);

                $this->info('Status: ' . self::API_STATUS_OK);
            }
        } catch (\Exception $e) {
            CarrierDynamicExpressApiStatus::create([
                'code' => self::API_STATUS_NOT_OK,
            ]);

            $this->newLine();
            $this->error('Status: ' . self::API_STATUS_NOT_OK);
            $this->error(
                $e->getMessage()
            );
        }

        return 0;
    }

    /**
     * clear
     *
     * @return void
     */
    protected function clear()
    {
        if ($days = $this->option('clear')) {
            $clearDate = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');

            $this->info("-> Carrier Dynamic Express Api Status : Clearing entries older than: {$clearDate}");

            CarrierDynamicExpressApiStatus::where('created_at', '<=', $clearDate)->delete();
        }
    }
}
