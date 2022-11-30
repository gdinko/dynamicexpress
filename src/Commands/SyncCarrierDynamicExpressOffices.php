<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressCountry;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressOffice;
use Gdinko\DynamicExpress\Traits\ValidatesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class SyncCarrierDynamicExpressOffices extends Command
{
    use ValidatesImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:sync-offices
                            {--country-iso= : Sync offices for country ISO Code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express offices and saves them in database';

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
        $this->info('-> Carrier Dynamic Express Import Offices');

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
                $this->info("{$i}/{$countryCount} Importing Offices for {$country->name} | ISO Code: {$country->iso}");

                try {
                    $this->importOffices($country->iso);

                    $this->newLine();
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
     * importOffices
     *
     * @param  mixed $countryIso
     * @return void
     */
    protected function importOffices($countryIso)
    {
        CarrierDynamicExpressOffice::where('country_iso', $countryIso)->delete();

        $offices = DynamicExpress::getOfficesCord($countryIso);

        $bar = $this->output->createProgressBar(
            count($offices)
        );

        $bar->start();

        if (! empty($offices)) {
            foreach ($offices as $office) {
                $validated = $this->validated($office);

                CarrierDynamicExpressOffice::create([
                    'dynamic_express_id' => $validated['ID'],
                    'name' => $validated['OFFICENAME'],
                    'office_type' => $validated['RTYPE'],
                    'country_iso' => $validated['COUNTRY_ID'],
                    'site_id' => $validated['SITEID'],
                    'city_uuid' => $this->getUuid(
                        $this->getSlug(
                            $this->getSlug(
                                $this->normalizeCityName(
                                    $validated['CITY']
                                )
                            ) . ' ' . $validated['PK']
                        )
                    ),

                    'city' => $validated['CITY'],
                    'post_code' => $validated['PK'],
                    'address' => $validated['ADDRESS'],
                    'lat' => $validated['LAT'],
                    'lng' => $validated['LNG'],
                    'meta' => [
                        'parcel_pickup' => $validated['PARCELPICKUP'] ?? 0,
                        'parcel_acceptance' => $validated['PARCELACCEPTANCE'] ?? 0,
                        'max_parcel_dimensions_w' => $validated['MAXPARCELDIMENSIONS_W'] ?? null,
                        'max_parcel_dimensions_h' => $validated['MAXPARCELDIMENSIONS_H'] ?? null,
                        'max_parcel_dimensions_l' => $validated['MAXPARCELDIMENSIONS_L'] ?? null,
                        'max_parcel_weight' => $validated['MAXPARCELWEIGHT'] ?? null,
                        'business_hours_d1' => $validated['D1'] ?? null,
                        'business_hours_d2' => $validated['D2'] ?? null,
                        'business_hours_d3' => $validated['D3'] ?? null,
                        'business_hours_d4' => $validated['D4'] ?? null,
                        'business_hours_d5' => $validated['D5'] ?? null,
                        'business_hours_d6' => $validated['D6'] ?? null,
                        'business_hours_d7' => $validated['D7'] ?? null,
                        'info' => $validated['INFO'] ?? null,
                    ],
                    'distance' => $validated['DISTANCE'],
                    'subcon_id' => $validated['SUBCON_ID'],
                    'office_ref' => $validated['OFFICEREF'],
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
            'ID' => 'numeric|nullable',
            'OFFICENAME' => 'string|required',
            'RTYPE' => 'required',
            'SITEID' => 'integer|nullable',
            'CITY' => 'string|nullable',
            'PK' => 'string|nullable',
            'ADDRESS' => 'string|nullable',
            'LAT' => 'string|required',
            'LNG' => 'string|required',
            'PARCELPICKUP' => 'boolean|nullable',
            'PARCELACCEPTANCE' => 'boolean|nullable',
            'MAXPARCELDIMENSIONS_W' => 'integer|nullable',
            'MAXPARCELDIMENSIONS_H' => 'integer|nullable',
            'MAXPARCELDIMENSIONS_L' => 'integer|nullable',
            'MAXPARCELWEIGHT' => 'integer|nullable',
            'D1' => 'string|nullable',
            'D2' => 'string|nullable',
            'D3' => 'string|nullable',
            'D4' => 'string|nullable',
            'D5' => 'string|nullable',
            'D6' => 'string|nullable',
            'D7' => 'string|nullable',
            'INFO' => 'string|nullable',
            'DISTANCE' => 'string|nullable',
            'SUBCON_ID' => 'numeric|nullable',
            'COUNTRY_ID' => 'integer|required',
            'OFFICEREF' => 'string|nullable',
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
