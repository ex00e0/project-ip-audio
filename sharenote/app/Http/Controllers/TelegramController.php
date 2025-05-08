<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Track; 

class TelegramController extends Controller
{
    private $token = '7513404240:AAGmtvRxN9ZJ0sYYrUed8zRg_9zxrJwGjH0';

    public function webhook(Request $request)
    {
        $update = $request->all();

        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];

            if (isset($message['text'])) {
                $text = $message['text'];

                if ($text === '/start') {
                    $this->sendMenu($chatId);
                } elseif ($text === 'Новинки') {
                    $this->sendLatestTracks($chatId);
                } elseif ($text === 'Найти трек') {
                    $this->sendMessage($chatId, 'Введите название трека:');
                } else {
                    $this->searchTrack($chatId, $text);
                }
            }
        }
    }
    // curl -X POST "https://api.telegram.org/bot7513404240:AAGmtvRxN9ZJ0sYYrUed8zRg_9zxrJwGjH0/deleteWebhook"
    // curl -X POST "https://api.telegram.org/bot7513404240:AAGmtvRxN9ZJ0sYYrUed8zRg_9zxrJwGjH0/setWebhook?url=https://emmaniasya.rf.gd/telegram/webhook"
    // curl -X GET "https://api.telegram.org/bot7513404240:AAGmtvRxN9ZJ0sYYrUed8zRg_9zxrJwGjH0/getWebhookInfo"

    private function sendMenu($chatId)
    {
        $keyboard = [
            'keyboard' => [
                [['text' => 'Новинки'], ['text' => 'Найти трек']]
            ],
            'resize_keyboard' => true
        ];

        $this->sendMessage($chatId, 'Выберите действие:', $keyboard);
    }

    private function sendLatestTracks($chatId)
    {
        $tracks = Track::latest()->take(10)->get();

        if ($tracks->isEmpty()) {
            $this->sendMessage($chatId, 'Нет новых треков.');
            return;
        }

        foreach ($tracks as $track) {
            $this->sendAudio($chatId, $track->file, $track->name);
        }
    }

    private function searchTrack($chatId, $query)
    {
        $track = Track::where('name', 'like', "%$query%")->first();

        if ($track) {
            $track_url = 'https://emmaniasya.rf.gd/audio/'.$track->file;
            $this->sendAudio($chatId, $track_url, $track->name);
        } else {
            $keyboard = [
                'keyboard' => [[['text' => 'Назад в меню']]],
                'resize_keyboard' => true
            ];
            $this->sendMessage($chatId, 'Ничего не найдено.', $keyboard);
        }
    }

    private function sendMessage($chatId, $text, $keyboard = null)
    {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => $keyboard ? json_encode($keyboard) : null
        ]);
    }

    private function sendAudio($chatId, $audioUrl, $title)
    {

        Http::post("https://api.telegram.org/bot{$this->token}/sendAudio", [
            'chat_id' => $chatId,
            'audio' => $audioUrl,
            'caption' => $title
        ]);
    }
}
