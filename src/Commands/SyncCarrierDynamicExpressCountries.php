<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressCountry;
use Gdinko\DynamicExpress\Traits\ValidatesImport;
use Illuminate\Console\Command;

class SyncCarrierDynamicExpressCountries extends Command
{
    use ValidatesImport;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:sync-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express countries and saves them in database';

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
        $this->info('-> Carrier Dynamic Express Import Countries');

        try {

            $this->import();

            $this->newLine(2);
        } catch (DynamicExpressImportValidationException $eive) {
            $this->newLine();
            $this->error(
                $eive->getMessage()
            );
            $this->error(
                print_r($eive->getErrors(), true)
            );
        } catch (\Exception $e) {
            $this->newLine();
            $this->error(
                $e->getMessage()
            );
        }

        return 0;
    }

    /**
     * import
     *
     * @return void
     */
    protected function import()
    {
        $countries = DynamicExpress::getCountries();

        $bar = $this->output->createProgressBar(count($countries));

        $bar->start();

        if (!empty($countries)) {
            CarrierDynamicExpressCountry::truncate();

            foreach ($countries as $country) {
                $validated = $this->validated($country);

                CarrierDynamicExpressCountry::create([
                    'iso' => $validated['COUNTRYID_ISO'],
                    'iso_alpha2' => $validated['ISO_ALPHA2'],
                    'name' => $validated['COUNTRYNAME'],
                ]);

                $bar->advance();
            }
        }

        $bar->finish();
    }

    /**
     * validationRules
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'COUNTRYID_ISO' => 'integer|required',
            'ISO_ALPHA2' => 'string|required',
            'COUNTRYNAME' => 'string|required',
        ];
    }
}
