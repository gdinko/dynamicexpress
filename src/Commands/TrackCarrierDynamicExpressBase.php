<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Events\CarrierDynamicExpressTrackingEvent;
use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Hydrators\Request;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressTracking;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

abstract class TrackCarrierDynamicExpressBase extends Command
{
    protected $parcels = [];

    protected $muteEvents = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:track
                            {--account= : Set Dynamic Express API Account}
                            {--clear= : Clear Database table from records older than X days}
                            {--timeout=20 : Dynamic Express API Call timeout}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track DynamicExpress parcels';

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
        $this->info('-> Carrier DynamicExpress Parcel Tracking');

        try {
            $this->setAccount();

            $this->setup();

            $this->clear();

            $this->track();

            $this->newLine(2);
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

        return 0;
    }

    /**
     * setAccount
     *
     * @return void
     */
    protected function setAccount()
    {
        if ($this->option('account')) {
            DynamicExpress::setAccountFromStore(
                $this->option('account')
            );
        }
    }

    /**
     * setup
     *
     * @return void
     */
    abstract protected function setup();

    /**
     * clear
     *
     * @return void
     */
    protected function clear()
    {
        if ($days = $this->option('clear')) {
            $clearDate = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');

            $this->info("-> Carrier DynamicExpress Parcel Tracking : Clearing entries older than: {$clearDate}");

            CarrierDynamicExpressTracking::where('created_at', '<=', $clearDate)->delete();
        }
    }

    /**
     * track
     *
     * @return void
     */
    protected function track()
    {
        $bar = $this->output->createProgressBar(
            count($this->parcels)
        );

        $bar->start();

        if (!empty($this->parcels)) {
            $trackingInfo = DynamicExpress::track_order_array(
                $this->parcels
            );

            if (!empty($trackingInfo)) {
                $this->processTracking($trackingInfo, $bar);
            }
        }

        $bar->finish();
    }

    /**
     * processTracking
     *
     * @param  array $trackingInfo
     * @param  mixed $bar
     * @return void
     */
    protected function processTracking(array $trackingInfo, $bar)
    {
        foreach ($trackingInfo as $tracking) {

            $parcelId = $tracking['AWB'];
            unset($tracking['AWB']);

            CarrierDynamicExpressTracking::updateOrCreate(
                [
                    'parcel_id' => $parcelId,
                ],
                [
                    'carrier_signature' => DynamicExpress::getSignature(),
                    'carrier_account' => DynamicExpress::getUserName(),
                    'meta' => $tracking,
                ]
            );

            if (!$this->muteEvents) {
                CarrierDynamicExpressTrackingEvent::dispatch(
                    array_pop($tracking),
                    DynamicExpress::getUserName()
                );
            }

            $bar->advance();
        }
    }
}
