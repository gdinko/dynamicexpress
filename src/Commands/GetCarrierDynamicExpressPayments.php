<?php

namespace Gdinko\DynamicExpress\Commands;

use Gdinko\DynamicExpress\Exceptions\DynamicExpressImportValidationException;
use Gdinko\DynamicExpress\Facades\DynamicExpress;
use Gdinko\DynamicExpress\Models\CarrierDynamicExpressPayment;
use Gdinko\DynamicExpress\Traits\ValidatesImport;
use Illuminate\Console\Command;

class GetCarrierDynamicExpressPayments extends Command
{
    use ValidatesImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-express:get-payments {--date_from=} {--date_to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets Dynamic Express payments and saves them in database';

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
        $this->info('-> Carrier Dynamic Express Import Payments');

        $dateFrom = $this->option('date_from') ?: date('Y-m-d');
        $dateTo = $this->option('date_to') ?: date('Y-m-d');

        $this->info("Date From: {$dateFrom} - Date To: {$dateTo}");

        $orders = DynamicExpress::getRazhodOrders($dateFrom, $dateTo);

        if (!empty($orders)) {

            $i = 1;
            $ordersCount = count($orders);

            foreach ($orders as $order) {

                $this->info("{$i}/{$ordersCount} Importing Payments RID: {$order['RID']}");

                try {

                    $this->import($order);

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

                $i++;
            }
        }

        return 0;
    }

    /**
     * import
     *
     * @param  array $order
     * @return void
     */
    protected function import(array $order)
    {

        $payments = DynamicExpress::getRazhodOrderInfo($order['RID']);

        $bar = $this->output->createProgressBar(
            count($payments)
        );

        $bar->start();

        if (!empty($payments)) {
            foreach ($payments as $payment) {
                $validated = $this->validated($payment);

                CarrierDynamicExpressPayment::create([
                    'num' => $validated['TOVARITELNICA'],
                    'rid' => $order['RID'],
                    'pay_type' => $order['PAYTYPE'],
                    'pay_date' => $validated['IZPLATENODATA'],
                    'amount' => $validated['SUMA'],
                    'meta' => [
                        'receiver' => $validated['RECEIVER'],
                        'client_ref1' => $validated['CLIENT_REF1'],
                    ],
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
            'TOVARITELNICA' => 'required',
            'SUMA' => 'numeric|required',
            'IZPLATENODATA' => 'date_format:Y-m-d H:i:s|required',
            'RECEIVER' => 'nullable',
            'CLIENT_REF1' => 'nullable',
        ];
    }
}
