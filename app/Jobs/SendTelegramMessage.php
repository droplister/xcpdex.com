<?php

namespace App\Jobs;

use Log;
use Telegram;
use Exception;
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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $chat_id=null)
    {
        $this->chat_id = $chat_id;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->sendMessage();
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
}