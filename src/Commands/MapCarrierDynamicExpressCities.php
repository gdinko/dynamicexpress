<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierCityMap;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressCountry;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressOffice;
use Gdinko\DynamicExpress\Traits\ValidatesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use League\ISO3166\ISO3166;
use Ramsey\Uuid\Uuid;

class MapCarrierDynamicExpressCities extends Command
{
    use ValidatesImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:map-cities
                            {country-iso : Sync cities for country ISO Code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express cities and makes carriers city map in database';

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
        $this->info('-> Carrier Dynamic Express Map Cities');

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
        $countryIso = $this->argument('country-iso');

        $countries = CarrierDynamicExpressCountry::where('iso', $countryIso)->get();

        if (! CarrierDynamicExpressOffice::where('country_iso', $countryIso)->count()) {
            $this->newLine();
            $this->warn('[WARN] Import Dynamic Express offices first to map office city ...');
            $this->newLine();
        }

        if ($countries->isNotEmpty()) {
            $countryCount = $countries->count();
            $i = 1;

            foreach ($countries as $country) {
                $this->newLine();
                $this->info("{$i}/{$countryCount} Map Cities for {$country->name} | ISO Code: {$country->iso}");

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
        $cities = DynamicExpress::getCityes($countryIso);

        $countryIsoCodes = (new ISO3166())->numeric($countryIso);

        $bar = $this->output->createProgressBar(
            count($cities)
        );

        $bar->start();

        if (! empty($cities) && ! empty($countryIsoCodes)) {
            CarrierCityMap::where(
                'carrier_signature',
                DynamicExpress::getSignature()
            )
                ->where('country_code', $countryIsoCodes['alpha3'])
                ->delete();

            foreach ($cities as $city) {
                $validated = $this->validated($city);

                $name = $this->normalizeCityName(
                    $validated['NAME']
                );

                $nameSlug = $this->getSlug($name);

                $slug = $this->getSlug(
                    $nameSlug . ' ' . $validated['POSTCODE']
                );

                $data = [
                    'carrier_signature' => DynamicExpress::getSignature(),
                    'carrier_city_id' => $validated['SITEID'],
                    'country_code' => $countryIsoCodes['alpha3'],
                    'region' => Str::title($validated['OBLAST']),
                    'name' => $name,
                    'name_slug' => $nameSlug,
                    'post_code' => $validated['POSTCODE'],
                    'slug' => $slug,
                    'uuid' => $this->getUuid($slug),
                ];

                CarrierCityMap::create(
                    $data
                );

                //set city_uuid to all offices with this site_id
                CarrierDynamicExpressOffice::where(
                    'site_id',
                    $validated['SITEID']
                )->update([
                    'city_uuid' => $data['uuid'],
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

    /**
     * normalizeCityName
     *
     * @param  string $name
     * @return string
     */
    protected function normalizeCityName(string $name): string
    {
        return Str::title(
            explode(',', $name)[0]
        );
    }

    /**
     * getSlug
     *
     * @param  string $string
     * @return string
     */
    protected function getSlug(string $string): string
    {
        return Str::slug($string);
    }

    /**
     * getUuid
     *
     * @param  string $string
     * @return string
     */
    protected function getUuid(string $string): string
    {
        return Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            $string
        )->toString();
    }
}
