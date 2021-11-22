<?php

namespace App\Jobs;

use Log;
use Telegram;
use Exception;
use Curl\Curl;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Chat
     *
     * @var integer
     */
    protected $chat_id;

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
    public function __construct($message, $chat_id=null, $card=null)
    {
        $this->chat_id = $chat_id;
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
            if($this->card) {
                $photo = $this->getPhotoUrl();
                if($photo && substr($photo, -3) === 'gif') {
                    $this->sendDocument($photo);
                } elseif($photo) {
                    $this->sendPhoto($photo);
                } else {
                    $this->sendMessage();
                }
            } else {
                $this->sendMessage();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function sendMessage()
    {
        return Telegram::sendMessage([
            'chat_id' => $this->chat_id === null ? config('xcpdex.channel_id') : $this->chat_id,
            'text' => $this->message,
            'parse_mode' => 'Markdown',
            'disable_notification' => true,
            'disable_web_page_preview' => true,
        ]);
    }

    private function sendDocument($photo)
    {
        return Telegram::sendDocument([
            'chat_id' => $this->chat_id === null ? config('xcpdex.channel_id') : $this->chat_id,
            'document' => InputFile::create($photo, $this->card . '.' . last(explode('.', $photo))),
            'caption' => $this->message,
            'parse_mode' => 'Markdown',
            'disable_notification' => true,
            'disable_web_page_preview' => true,
        ]);
    }

    private function sendPhoto($photo)
    {
        return Telegram::sendPhoto([
            'chat_id' => $this->chat_id === null ? config('xcpdex.channel_id') : $this->chat_id,
            'photo' => InputFile::create($photo, $this->card . '.' . last(explode('.', $photo))),
            'caption' => $this->message,
            'parse_mode' => 'Markdown',
            'disable_notification' => true,
            'disable_web_page_preview' => true,
        ]);
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

        $curl = new Curl();
        $curl->setUserAgent('XCPDEX.com');
        $curl->get('https://digirare.com/api/widget/' . $this->card);

        if ($curl->error) {
            return null;
        } else {
            $response = json_decode($curl->response);
            return 'https://digirare.com' . $response->data->image;
        }

        return null;
    }
}