<?php

namespace App\Jobs;

use Log;
use Exception;
use Droplister\XcpCore\App\Asset;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDiscordMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Message
     *
     * @var string
     */
    protected $message;

    /**
     * Card
     *
     * @var string
     */
    protected $card;

    /**
     * Quantity
     *
     * @var string
     */
    protected $quantity;

    /**
     * Price
     *
     * @var string
     */
    protected $price;

    /**
     * Destination
     *
     * @var string
     */
    protected $destination;

    /**
     * TX Hash
     *
     * @var string
     */
    protected $tx_hash;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $card, $quantity, $price, $destination, $tx_hash)
    {
        $this->message = $message;
        $this->card = $card;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->destination = $destination;
        $this->tx_hash = $tx_hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($photo = $this->getPhotoUrl()) {
                $this->sendMessage($photo);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function sendMessage($photo)
    {
    	$asset = Asset::whereAssetName($this->card)->first();
    	$issued = $this->trimTrailingZeroes($asset->issuance_normalized);
    	$burned = $asset->burned > 0 ? " (" . $this->trimTrailingZeroes($asset->burned_normalized) . " burned)" : "";

		//=======================================================================================================
		// Create new webhook in your Discord channel settings and copy&paste URL
		// Source: https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c
		//=======================================================================================================

		$webhookurl = config('xcpdex.discord_webhook');

		//=======================================================================================================
		// Compose message. You can use Markdown
		// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
		//========================================================================================================

		$timestamp = date("c", strtotime("now"));

		$json_data = json_encode([
			"username" => "XCP BOT",
			"avatar_url" => "https://xcpdex.com/images/xcp-bot.png",
			"content" => $this->message,
		    "embeds" => [
		        [
		            // Embed Type
		            "type" => "rich",

		            "title" => $this->card,

		            "description" => "Issued: {$issued}{$burned}",

		            // Timestamp of embed must be formatted as ISO8601
		            "timestamp" => $timestamp,

		            // Embed left border color in HEX
		            "color" => hexdec( "3366ff" ),

		            // Footer
		            "footer" => [
		                "text" => "DIGIRARE",
		                "icon_url" => "https://xcpdex.com/images/digirare.png"
		            ],

		            // Image to send
		            "image" => [
		                "url" => $photo,
		            ],

		            // Additional Fields array
		            "fields" => [
		                // Field 1
		                [
		                    "name" => "Destination",
		                    "value" => "[{$this->destination}](https://xchain.io/tx/{$this->tx_hash})",
		                    "inline" => false
		                ],
		                // Field 2
		                [
		                    "name" => "Price",
		                    "value" => "{$this->price} BTC",
		                    "inline" => true
		                ],
		                // Field 3
		                [
		                    "name" => "Quantity",
		                    "value" => $this->quantity,
		                    "inline" => true
		                ],
		            ]
		        ]
		    ]

		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

		$ch = curl_init( $webhookurl );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );
		// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
		// echo $response;
		curl_close( $ch );
    }

    private function getPhotoUrl()
    {
        foreach(['jpg', 'png', 'jpeg', 'gif'] as $ext) {
            $url = "https://xchain.io/img/cards/{$this->card}.{$ext}";
              
            $array = @get_headers($url);

            $string = $array[0];
              
            if(strpos($string, '200')) {
                return $url;
            }
        }

        return null;
    }

    private function trimTrailingZeroes($nbr) {
        if(strpos($nbr,'.')!==false) $nbr = rtrim($nbr,'0');

        return rtrim($nbr,'.') ?: '0';
    }
}