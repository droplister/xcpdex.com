<?php

namespace App\Jobs;

use JsonRPC\Client;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\TransactionOutput;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SnipeDispenser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Dispenser
     *
     * @var string
     */
    protected $dispenser;

    /**
     * Bitcoin Core API
     *
     * @var \JsonRPC\Client
     */
    protected $bitcoin;

    /**
     * Counterparty API
     *
     * @var \JsonRPC\Client
     */
    protected $counterparty;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dispenser)
    {
        $this->dispenser = $dispenser;
        $this->bitcoin = new Client(config('xcp-core.bc.api'));
        $this->bitcoin->authentication(config('xcp-core.bc.user'), config('xcp-core.bc.password'));
        $this->counterparty = new Client(config('xcp-core.cp.api'));
        $this->counterparty->authentication(config('xcp-core.cp.user'), config('xcp-core.cp.password'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Makes Raw TX
        $unsigned = $this->createSend($this->dispenser->source, $this->dispenser->satoshirate);

        // Sign the HEX
        $signed = $this->signSendTx($unsigned);

        // Publish TX
        $send = $this->publishSend($signed);
    }

    /**
     * Counterparty API
     * https://counterparty.io/docs/api/#get_table
     *
     * @return mixed
     */
    private function createSend($address, $amount)
    {
        try {
            return $this->counterparty->execute('create_send', [
                'source' => config('xcpdex.sniper_address'),
                'destination' => $address,
                'asset' => 'BTC',
                'quantity' => $amount,
                'allow_unconfirmed_inputs' => true,
                'fee' => 10000,
            ]);
        } catch (Throwable $e) {
            \Log::info('Unsigned Failed');
            return null;
        }
    }

    /**
     * Sign Bitcoin TX
     * https://bitcoin.stackexchange.com/questions/46764/sign-transaction-hex-with-php-library/46797
     *
     * @return mixed
     */
    private function signSendTx($hex) {

        try {
            $privateKey = config('xcpdex.sniper_private_key');

            $tx = TransactionFactory::fromHex($hex);

            $transactionOutputs = [];
            foreach ($tx->getInputs() as $idx => $input) {
                $transactionOutput = new TransactionOutput(0, ScriptFactory::fromHex($input->getScript()->getBuffer()->getHex()));
                array_push($transactionOutputs, $transactionOutput);
            }

            $priv = PrivateKeyFactory::fromWif($privateKey);
            $signer = new Signer($tx, Bitcoin::getEcAdapter());

            foreach ($transactionOutputs as $idx => $transactionOutput) {
                $signer->sign($idx, $priv, $transactionOutput);
            }

            $signed = $signer->get();

            return $signed->getHex();
        } catch (Throwable $e) {
            \Log::info('Failed to Sign');
            return null;
        }
    }

    /**
     * Bitcoin Core API
     * https://bitcoin.org/en/developer-reference#sendrawtransaction
     *
     * @return mixed
     */
    private function publishSend($raw_tx)
    {
        try {
            return $this->bitcoin->execute('sendrawtransaction', [
                $raw_tx,
            ]);
        } catch (Throwable $e) {
            \Log::info('Failed to Send');
            return null;
        }
    }
}