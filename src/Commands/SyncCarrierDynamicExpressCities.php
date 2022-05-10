<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressCity;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressCountry;
use Gdinko\DynamicExpress\Traits\ValidatesImport;
use Illuminate\Console\Command;

class SyncCarrierDynamicExpressCities extends Command
{
    use ValidatesImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:sync-cities {--country-iso= : Sync cities for country ISO Code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express cities and saves them in database';

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
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('-> Carrier Dynamic Express Import Cities');

        $this->import();

        return 0;
    }

    /**
     * import
     *
     * @return void
     */
    protected function import()
    {
        $countries = CarrierDynamicExpressCountry::when($this->option('country-iso'), function ($q, $countryIso) {
            return $q->where('iso', $countryIso);
        })->get();

        if ($countries->isNotEmpty()) {
            $countryCount = $countries->count();
            $i = 1;

            foreach ($countries as $country) {
                $this->newLine();
                $this->info("{$i}/{$countryCount} Importing Cities for {$country->name} | ISO Code: {$country->iso}");

                try {
                    $this->importCities($country->iso);
                } catch (DynamicExpressImportValidationException $eive) {
                    $this->newLine();
                    $this->error(
                        $eive->getMessage()
                    );
                    $this->info(
                        print_r($eive->getData(), true)
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

                $i++;
            }
        }
    }

    /**
     * importCities
     *
     * @param  mixed $countryIso
     * @return void
     */
    protected function importCities($countryIso)
    {
        CarrierDynamicExpressCity::where('country_iso', $countryIso)->delete();

        $cities = DynamicExpress::getCityes($countryIso);

        $bar = $this->output->createProgressBar(
            count($cities)
        );

        $bar->start();

        if (! empty($cities)) {
            foreach ($cities as $city) {
                $validated = $this->validated($city);

                CarrierDynamicExpressCity::create([
                    'country_iso' => $validated['COUNTRYID_ISO'],
                    'site_id' => $validated['SITEID'],
                    'name' => $validated['NAME'],
                    'region' => $validated['OBLAST'],
                    'municipality' => $validated['OBSHTINA'],
                    'site_type' => $validated['SITETYPE'],
                    'post_code' => $validated['POSTCODE'],
                    'eknm' => $validated['EKNM'],
                    'delivery_weekdays' => $validated['DELIVERYWEEKDAYS'] ?? null,
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
            'NAME' => 'string|required',
            'COUNTRYID_ISO' => 'numeric|required',
            'SITEID' => 'numeric|required',
            'OBLAST' => 'string|nullable',
            'OBSHTINA' => 'string|nullable',
            'SITETYPE' => 'string|nullable',
            'POSTCODE' => 'required',
            'EKNM' => 'nullable',
            'DELIVERYWEEKDAYS' => 'string|nullable',
        ];
    }
}
