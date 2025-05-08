<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\Telegram\Bot\FileUpload\InputFile;

class StartCommand extends Command
{
    protected $signature = 'bot:start';
    protected $description = 'Run the Telegram bot using long polling';

    public function handle()
    {
        // ответ в консоль
        $this->info('В работе...');

        // токен бота
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $offset = 0;
        // цикл проверки без конца
        $remember = 0;

        while (true) {
            // проверка на наличие новых сообщений
            $updates = $telegram->getUpdates([
                'offset' => $offset,
                'timeout' => 30,
            ]);
            
            
            foreach ($updates as $update) {
                // пропуск предыдущих итераций
                $offset = $update->getUpdateId() + 1;
                // объект сообщения
                $message = $update->getMessage();
                // ID и текст из объекта
                $chatId = $message->getChat()->getId();
                $text = $message->getText();

// проверка команды
                if ($text === '/start') {
                    $keyboard = Keyboard::make()->
                    setResizeKeyboard(true)->
                    setOneTimeKeyboard(true)->
                    row([
                        Keyboard::button('Новинки'), 
                        Keyboard::button('Поиск трека'),
                        Keyboard::button('Топ треков'),
                    ]);
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Привет! Это бот для аудиохостинга, где можно найти треки или прослушать новинки',
                        'reply_markup' => $keyboard
                    ]);
                }
                else if($text === 'Поиск трека'){
                    $remember = 1;
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Введите название трека (Загрузка аудиозаписей может занять какое-то время, подождите).',
                    ]);
                    
                }
                else if($text === 'Новинки'){
                    $counter = 0;
                    $res = DB::table('tracks')->latest()->limit(10)->get();
                    $count_res = $res->count();
                    foreach ($res as $rr) {
                        $counter++;
                        $track_url = public_path('audio/' . $rr->file);
                        if ($counter == 10 || $count_res == $counter) {
                            $telegram->sendAudio([
                                'chat_id' => $chatId,
                                'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                                'caption' => $rr->name
                            ]);
                            $keyboard = Keyboard::make()->
                        setResizeKeyboard(true)->
                        setOneTimeKeyboard(true)->
                        row([
                            Keyboard::button('Новинки'), 
                            Keyboard::button('Поиск трека'),
                            Keyboard::button('Топ треков'),
                        ]);
                            $telegram->sendMessage([
                                'chat_id' => $chatId,
                                'text' => 'Это текущие новинки треков. Можете продолжить работу с ботом через меню.',
                                'reply_markup' => $keyboard
                            ]);
                        } else {
                             $telegram->sendAudio([
                            'chat_id' => $chatId,
                            'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                            'caption' => $rr->name
                            ]);
                        }
                        
                    }
                    
                }
                else if($text === 'Топ треков'){
                    $counter = 0;
                    $res = DB::table('tracks')->selectRaw('count(saves.id) as count_s, tracks.name, tracks.file')->join('saves', 'tracks.id', '=', 'saves.track_id', 'left outer')->groupBy('tracks.id')->orderBy('count_s', 'DESC')->limit(10)->get();
                    $count_res = $res->count();
                    foreach ($res as $rr) {
                        $counter++;
                        $track_url = public_path('audio/' . $rr->file);
                        if ($counter == 10 || $count_res == $counter) {
                            $telegram->sendAudio([
                                'chat_id' => $chatId,
                                'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                                'caption' => $counter.'. '.$rr->name
                            ]);
                            $keyboard = Keyboard::make()->
                        setResizeKeyboard(true)->
                        setOneTimeKeyboard(true)->
                        row([
                            Keyboard::button('Новинки'), 
                            Keyboard::button('Поиск трека'),
                            Keyboard::button('Топ треков'),
                        ]);
                            $telegram->sendMessage([
                                'chat_id' => $chatId,
                                'text' => 'Это топ-10 популярных на текущий момент треков. Можете продолжить работу с ботом через меню.',
                                'reply_markup' => $keyboard
                            ]);
                        }
                        else {
                            $telegram->sendAudio([
                                'chat_id' => $chatId,
                                'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                                'caption' => $counter.'. '.$rr->name
                            ]);
                        }
                        
                    }
                    
                }
                else {
                if ($remember == 1) {
                    $remember = 0;
                    $counter = 0;
                    $res = DB::table('tracks')->where('name','LIKE', "%$text%")->limit(10)->get();
                    $count_res = $res->count();
                    if ($count_res != 0) {
                        foreach ($res as $rr) {
                            $counter++;
                            if ($counter == 10 || $counter == $count_res) {
                                $track_url = public_path('audio/' . $rr->file);
                                $telegram->sendAudio([
                                    'chat_id' => $chatId,
                                    'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                                    'caption' => $rr->name
                                ]);
                                $keyboard = Keyboard::make()->
                            setResizeKeyboard(true)->
                            setOneTimeKeyboard(true)->
                            row([
                                Keyboard::button('Новинки'), 
                                Keyboard::button('Поиск трека'),
                                Keyboard::button('Топ треков'),
                            ]);
                                $telegram->sendMessage([
                                    'chat_id' => $chatId,
                                    'text' => 'Это все треки, которые были найдены по данному названию. Можете продолжить работу с ботом через меню.',
                                    'reply_markup' => $keyboard
                                ]);
                            }
                            else {
                                $track_url = public_path('audio/' . $rr->file);
                                $telegram->sendAudio([
                                   'chat_id' => $chatId,
                                   'audio' => \Telegram\Bot\FileUpload\InputFile::create($track_url),
                                   'caption' => $rr->name
                               ]);
                            }
                            
                        }
                        
                    }
                    else {
                        $keyboard = Keyboard::make()->
                        setResizeKeyboard(true)->
                        setOneTimeKeyboard(true)->
                        row([
                            Keyboard::button('Новинки'), 
                            Keyboard::button('Поиск трека'),
                            Keyboard::button('Топ треков'),
                        ]);
                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'По такому запросу треков нет. Вы можете вернуться в меню и попробовать снова с другим запросом.',
                            'reply_markup' => $keyboard
                            
                        ]);
                    }
                    
                }
                else {$keyboard = Keyboard::make()->
                        setResizeKeyboard(true)->
                        setOneTimeKeyboard(true)->
                        row([
                            Keyboard::button('Новинки'), 
                            Keyboard::button('Поиск трека'),
                            Keyboard::button('Топ треков'),
                        ]);
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Такой команды нет, выберите команды из меню',
                        'reply_markup' => $keyboard
                        
                    ]);
                }
                   
                }
            }
            // пауза между запросами
            sleep(1); 
        }
    }
}