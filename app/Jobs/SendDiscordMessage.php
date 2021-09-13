<?php

namespace App\Jobs;

use Log;
use Exception;
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
     * Asset
     *
     * @var string
     */
    protected $card;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $card)
    {
        $this->message = $message;
        $this->card = $card;
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
			"content" => "Test 123",
		    "embeds" => [
		        [
		            // Embed Title
		            "title" => "PHP - Send message to Discord (embeds) via Webhook",

		            // Embed Type
		            "type" => "rich",

		            // Embed Description
		            "description" => "Description will be here, someday, you can mention users here also by calling userID <@12341234123412341>",

		            // URL of title link
		            "url" => "https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c",

		            // Timestamp of embed must be formatted as ISO8601
		            "timestamp" => $timestamp,

		            // Embed left border color in HEX
		            "color" => hexdec( "3366ff" ),

		            // Footer
		            "footer" => [
		                "text" => "GitHub.com/Mo45",
		                "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
		            ],

		            // Image to send
		            "image" => [
		                "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
		            ],

		            // Thumbnail
		            //"thumbnail" => [
		            //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
		            //],

		            // Author
		            "author" => [
		                "name" => "krasin.space",
		                "url" => "https://krasin.space/"
		            ],

		            // Additional Fields array
		            "fields" => [
		                // Field 1
		                [
		                    "name" => "Field #1 Name",
		                    "value" => "Field #1 Value",
		                    "inline" => false
		                ],
		                // Field 2
		                [
		                    "name" => "Field #2 Name",
		                    "value" => "Field #2 Value",
		                    "inline" => true
		                ]
		                // Etc..
		            ]
		        ]
		    ]

		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

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
}