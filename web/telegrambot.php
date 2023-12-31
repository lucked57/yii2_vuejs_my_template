<?php
error_reporting(E_ALL); // вывод ошибок
###############################################
define(API_TOKEN, '6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ'); // тут прописываем свой токен
define(URL, 'https://api.telegram.org/bot'.API_TOKEN); // глобальная ссылка для получение json данных (не трогать)
###############################################

class BOT { // Создаем класс BOT
    /* создаем метод sendMessage с аргументами
     * $chatid          - ид получателя
     * $msg             - сообщение
     * $keyboard        - клавиатура
     * $keyboard_opt[0] - тип клавиатуры keyboard | inline_keyboard
     * $keyboard_opt[1] - спрятать клавиатуру при клике
     * $keyboard_opt[2] - авторазмер клавиатуры при клике
     * $parse_preview[0]- маркировка html| markdown
     * $parse_preview[1]- предпросмотр ссылок
     */
    function sendMessage($chatid, $msg, $keyboard = [], $keyboard_opt = [], $parse_preview = ['html', false]) {
        if(empty($keyboard_opt)) {
            $keyboard_opt[0] = 'keyboard';
            $keyboard_opt[1] = false;
            $keyboard_opt[2] = true;
        }
        $options = [
            $keyboard_opt[0]    => $keyboard,
            'one_time_keyboard' => $keyboard_opt[1],
            'resize_keyboard'   => $keyboard_opt[2],
        ];
        $replyMarkups   = json_encode($options);
        $removeMarkups  = json_encode(['remove_keyboard' => true]);

        // если в массиве $keyboard передается [0], то клавиатура удаляется
        if($keyboard == [0]) { file_get_contents(URL.'/sendMessage?disable_web_page_preview='.$parse_preview[1].'&chat_id='.$chatid.'&parse_mode='.$parse_preview[0].'&text='.urlencode($msg).'&reply_markup='.urlencode($removeMarkups)); }

        // или же если в массиве $keyboard передается [], то есть пустой массив, то клавиатура останется прежней
        else if($keyboard == []) { file_get_contents(URL.'/sendMessage?disable_web_page_preview='.$parse_preview[1].'&chat_id='.$chatid.'&parse_mode='.$parse_preview[0].'&text='.urlencode($msg)); }

        // если вышеуказанные условия не соблюдены, значит в $keyboard передается клавиатура, которую вы создали
        else { file_get_contents(URL.'/sendMessage?disable_web_page_preview='.$parse_preview[1].'&chat_id='.$chatid.'&parse_mode='.$parse_preview[0].'&text='.urlencode($msg).'&reply_markup='.urlencode($replyMarkups)); }
    }
    function sendMessagePicture($chat_id,$token,$fileurl,$filetype,$filename,$caption){
        //$token = "6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ";

        $arrayQuery = array(
            'chat_id' => $chat_id,
            'caption' => $caption,
            'document' => curl_file_create($fileurl, $filetype , $filename)
        );      
        $ch = curl_init('https://api.telegram.org/bot'. $token .'/sendDocument');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
    }
}

?>