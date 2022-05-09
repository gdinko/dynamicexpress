<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressApiStatus;
use Illuminate\Console\Command;

class GetCarrierDynamicExpressApiStatus extends Command
{
    public const API_STATUS_OK = 200;
    public const API_STATUS_NOT_OK = 404;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:api-status';

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
            $countries = DynamicExpress::getCountries();

            if (! empty($countries)) {
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
}
