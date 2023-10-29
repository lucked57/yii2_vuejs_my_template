<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Login;
use app\components\Uservaludate;
use app\components\Bottelegram;
use yii\helpers\Url;


class SiteController extends AppController
{
    public $enableCsrfValidation = false; //Если это включить то axios работает
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(  Uservaludate::validateCookieModerator() ){
            $moderator = true;
        }
        else{
            $moderator = false;
        }


        if(  Uservaludate::validateCookie() ){
            $admin = true;
        }
        else{
            $admin = false;
        }




        /*Yii::$app->mailer->compose()
            ->setFrom('from@domain.com')
            ->setTo('ip557799@gmail.com')
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->send();*/
        //axios reguest
        if (Yii::$app->request->isPost){
            if($admin){
            $_POST = json_decode(file_get_contents('php://input'), true);
            if(!empty($_POST['id']) && !empty($_POST['edittext'])){
                if($_POST['target'] == 'change'){
                    //Код для добавления в БД
                //Yii::$app->db->createCommand()->update('user', ['text' => $_POST['edittext']], 'id = '.$_POST['id'])->execute();

                /*update = Training::findone($_POST['id']);
                $update->text = $_POST['edittext';
                $update->save();*/

                  return 'Текст успешно изменен '.$_POST['edittext'];  
                } 
                if($_POST['target'] == 'select'){
                  //Код для вывода из БД, где return - данные для заполнения

                //$return = Training::find()->asArray()->where(['id' => $_POST['id']])->one();
                    //$return = $return['text'];
                    $return = 'Текст для заполнения';
                  return $return;  
                }   
            }
            }
        }
 
        $lang = Uservaludate::routing_lang();

            $title = "Week - Stats";
            $keywords = 'keywords';
            $description = 'description';
        
        
         $this->view->title = $title;
         $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
         $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);

        if($admin){
            return $this->render('index', compact('lang'));
        }
        else{
            return $this->redirect('/login');
        }
    }

    public function actionAddpost()
    {

        if(  Uservaludate::validateCookieModerator() ){
            $moderator = true;
        }
        else{
            $moderator = false;
        }


        if(  Uservaludate::validateCookie() ){
            $admin = true;
        }
        else{
            $admin = false;
        }
        if($admin){
        if (Yii::$app->request->isPost && $admin){

            


            $files      = $_FILES; 
            $done_files = array();
            if(!empty($files)){
            foreach( $files as $file ){
                 
    
                $errors = null;
                if(empty(trim($_POST['title'])) || empty(trim($_POST['text']))){
                    $errors = 'Заполните название и текст';
                }
                if($file['size'] == 0){
                    $errors = 'Загрузите файл';
                }
                $imageinfo = getimagesize($file['tmp_name']);
        
                         if($imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg') {
                  $errors = "неподдерживаемый формат";
                 }

                 if(empty($errors)){
                    $file_name = uniqid();
                    $file_name = $file_name.".jpeg";
                    if(move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/web/img/post/'.$file_name )){
                        $img_return = 'Файл успешно загружен '.$_POST['title'].' '.$_POST['text'];
                    }
                 }
                 else{
                    $img_return = $errors;
                 }
            }
            }
            else{
                $img_return = 'пустой файл';
            }

            return $img_return;
        }
        return $this->render('addpost');
        }
        else{
            return $this->redirect('/');
        }
}


public function actionAddphoto()
    {

        if(  Uservaludate::validateCookieModerator() ){
            $moderator = true;
        }
        else{
            $moderator = false;
        }


        if(  Uservaludate::validateCookie() ){
            $admin = true;
        }
        else{
            $admin = false;
        }
        if($admin){
        if (Yii::$app->request->isPost && $admin){

            
            //$_POST['title']
            //$_POST['text']

            $files      = $_FILES; 
            $done_files = array();
            if(!empty($files)){
            foreach( $files as $file ){
                 
    
                $errors = null;
                if($file['size'] == 0){
                    $errors = 'Загрузите файл';
                }
                $imageinfo = getimagesize($file['tmp_name']);
        
                         if($imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg') {
                  $errors = "неподдерживаемый формат";
                 }

                 if(empty($errors)){
                    $file_name = uniqid();
                    $file_name = $file_name.".jpeg";

                    if(empty($_POST['title']) && empty($_POST['text'])){ //Если просто картника без описания и названия
                        if(move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/web/img/post/'.$file_name )){
                        $img_return = 'Файл успешно загружен';
                        }
                    }
                    else{



                    if(move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/web/img/post/'.$file_name )){
                        $img_return = 'Файл успешно загружен '.$_POST['title'].' '.$_POST['text'];
                    }
                    }
                 }
                 else{
                    $img_return = $errors;
                 }
            }
            }
            else{
                $img_return = 'пустой файл';
            }

            return $img_return;
        }
        return $this->render('addphoto');
        }
        else{
            return $this->redirect('/');
        }
}

    
    

    
    
    public function actionLogexit(){

        
                        $cookies = Yii::$app->response->cookies;
                    
                        unset($cookies['admin']);
                        unset($cookies['moderator']);
                        unset($cookies['auth_key']);
                        return $this->redirect('/');
    }

    public function actionWeekbot(){
        $token = "6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ";
        $link1 = "https://api.telegram.org/bot".$token;
        $fulllink = "https://api.telegram.org/bot6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ";
        //$url = 'https://week-app-api-dev.ru/webold';
        $url = 'https://web.week-app-api-dev.ru/api/v1';
        $request = Yii::$app->request;
        //https://api.telegram.org/bot6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ/setWebhook?url=http://weekcopy.mcdir.ru/web/weektelegrambot.php

//https://api.telegram.org/bot6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ/setWebhook?url=https://pawleashclub.ee/web/weektelegrambot.php

        //https://api.telegram.org/bot6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ/setWebhook?url=https://week-api-bot.ru/web/weektelegrambot.php

        //https://api.telegram.org/bot6032084803:AAEM7B35c7HXmxkUogkmDpQ9Lh7Mtizo-RQ/setWebhook?url=https://week-api-bot.ru/site/weekbot

        if (Yii::$app->request->isPost){


        $output         = json_decode(file_get_contents('php://input'), true);  // Получим то, что передано скрипту ботом в POST-сообщении и распарсим

$chat_id        = @$output['message']['chat']['id'];                    // идентификатор чата
$user_id        = @$output['message']['from']['id'];                    // идентификатор пользователя
$username       = @$output['message']['from']['username'];              // username пользователя
$first_name     = @$output['message']['chat']['first_name'];            // имя собеседника
$last_name      = @$output['message']['chat']['last_name'];             // фамилию собеседника
$chat_time      = @$output['message']['date'];                          // дата сообщения
$message        = @$output['message']['text'];                          // Выделим сообщение собеседника (регистр по умолчанию)
$msg            = mb_strtolower(@$output['message']['text'], "utf8");   // Выделим сообщение собеседника (нижний регистр)

$callback_query = @$output["callback_query"];                           // callback запросы
$data           = $callback_query['data'];                              // callback данные для обработки inline кнопок

$message_id     = $callback_query['message']['message_id'];             // идентификатор последнего сообщения
$chat_id_in     = $callback_query['message']['chat']['id'];             // идентификатор чата
############################################################################
$message_original = $message;
$message = mb_convert_case($message, MB_CASE_UPPER, "UTF-8");
if(mb_substr(trim($message),0,12) == "НОМЕР ЗАКАЗА"){
    $order_id = trim(mb_substr($message,13));
    $message = "НОМЕР ЗАКАЗА";
}
switch($message) { // в переменной $message содержится сообщение, которое мы отправляем боту.
    case '/START': 
         /*Yii::$app->db->createCommand()
             ->update('user', ['code_email' => $first_name], 'id = 2')
             ->execute();*/
            /* Yii::$app->db->createCommand()->insert('user', [
                    'code_email' => $first_name,
                    'username' => $message,
                ])->execute();*/
             //Yii::$app->db->createCommand()->delete('user', 'status = 0')->execute();
                Yii::$app->db->createCommand()->insert('bot_info', [
                    'platform' => 'telegram',
                    'username' => $username,
                    'first_name' => $first_name,
                    'chat_id' => $chat_id,
                    'user_id' => $user_id,
                    'messange' => $message_original,
                    'chat_time' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'data' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'data_time' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'answer' => "Здравствуйте, ".$first_name."! Как я могу Вам помочь?",
                    'understand' => true,
                ])->execute();
    Bottelegram::sendMessage($user_id, "Здравствуйте😊, ".$first_name."! Как я могу Вам помочь?", [['Совместная покупка', 'Статус заказа'], ['Сколько я могу экономить', 'Таблица заказов'], ['Регистрация', 'Заказать товар'], ['Как сменить пароль','Доставка']]); break;
    case 'ПРИВЕТ': Bottelegram::sendMessage($user_id, "Здравствуйте😊, ".$first_name."! Как я могу Вам помочь?", [['Совместная покупка', 'Статус заказа'], ['Сколько я могу экономить', 'Таблица заказов'], ['Регистрация', 'Заказать товар'], ['Как сменить пароль','Доставка']]); break;
    case 'СТАРТ': Bottelegram::sendMessage($user_id, "Здравствуйте😊, ".$first_name."! Как я могу Вам помочь?", [['Совместная покупка', 'Статус заказа'], ['Сколько я могу экономить', 'Таблица заказов'], ['Регистрация', 'Заказать товар'], ['Как сменить пароль','Доставка']]); break;
    case "'СТАРТ'": Bottelegram::sendMessage($user_id, "Здравствуйте😊, ".$first_name."! Как я могу Вам помочь?", [['Совместная покупка', 'Статус заказа'], ['Сколько я могу экономить', 'Таблица заказов'], ['Регистрация', 'Заказать товар'], ['Как сменить пароль','Доставка']]); break;
    case 'СОВМЕСТНАЯ ПОКУПКА': Bottelegram::sendMessage($user_id, "Наша система сама объединяет 👐 людей на один и тот же товар, позволяя экономить за счет этого, бренды в свою очередь самостоятельно определяют условия совместной покупки. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case 'ДОСТАВКА': Bottelegram::sendMessage($user_id, "Доставка🚚 товара осуществляется со стороны продавца, условия которой заранее согласовываются с покупателем. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case 'СКОЛЬКО Я МОГУ ЭКОНОМИТЬ': Bottelegram::sendMessage($user_id, "Исследования показали что на каждой покупке вы можете сэкономить🔥🔥🔥 от 10% до 20% и при этом процесс покупки для вас не становится сложнее. Вы покупаете так же в один клик. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case 'НЕТ АЙФОНА': Bottelegram::sendMessage($user_id, "К сожалению наше приложение на текущий момент доступно только для платформы ios📱, но мы уже работает на веб версией для всех устройств. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case 'РЕГИСТРАЦИЯ': Bottelegram::sendMessage($user_id, "Вы можете скачать приложении WEEK по данной ссылке 👉👉👉 https://apps.apple.com/ru/app/week/id1597771607  ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']], ['keyboard', false, true], ['html', false]); break;
    case 'УДАЛИТЬ КНОПКИ': Bottelegram::sendMessage($user_id, "Кнопки удалены, если их нужно вернуть то, напишите: 'старт'", [0]); break;
    case 'НЕТ': Bottelegram::sendMessage($user_id, "Рады Вам помочь😊! Если у Вас появятся еще вопрсоы, то напишите 👉 'старт'", [0]); break;
    case 'ДА': Bottelegram::sendMessage($user_id, "Как я могу Вам помочь?", [['Совместная покупка', 'Статус заказа'], ['Сколько я могу экономить', 'Таблица заказов'], ['Регистрация', 'Заказать товар'], ['Как сменить пароль','Доставка']]); break;
    case '/A': Bottelegram::sendMessage($user_id, "Наша система сама объединяет людей на один и тот же товар, позволяя экономить за счет этого, брэнды в свою очередь самостоятельно определяют условия совместной покупки. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case '/B': Bottelegram::sendMessage($user_id, "Доставка товара осуществляется со стороны продавца, условия которой заранее согласовываются с покупателем. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case '/C': Bottelegram::sendMessage($user_id, "Исследования показали что на каждой покупке вы можете сэкономить от 10% до 20% и при этом процесс покупки для вас не становится сложнее. Вы покупаете так же в один клик. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case '/D': Bottelegram::sendMessage($user_id, "К сожалению наше приложение на текущий момент доступно только для платформы ios, но мы уже работает на веб версией для всех устройств. ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]); break;
    case '/F': Bottelegram::sendMessage($user_id, "Вы можете скачать приложении WEEK по данной ссылке https://apps.apple.com/ru/app/week/id1597771607  ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']], ['keyboard', false, true], ['html', false]); break;
    case 'КАРТИНКА': Bottelegram::sendMessagePicture($chat_id,$token,$request->hostInfo.'/web/img/post/639c371decde9.jpeg','image/jpeg','639c371decde9.jpeg','Отправка картинка php week');
        Bottelegram::sendMessage($user_id, "Картинка была отправлена📷 ".$first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]);
     break;
     case 'КАК СМЕНИТЬ ПАРОЛЬ': Bottelegram::sendMessagePicture($chat_id,$token,$request->hostInfo.'/web/img/docs/videos/HowToChangePass.MP4','video/mp4','HowToChangePass.MP4','Смена пароля в приложении WEEK');
        Bottelegram::sendMessage($user_id, $first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]);//HowToChangePass.MP4//temp_0d5db55f-4dd6-4a2d-9c46-5205eaf94173.xlsx
     break;
     case 'ТАБЛИЦА ЗАКАЗОВ': Bottelegram::sendMessagePicture($chat_id,$token,$request->hostInfo.'/web/img/docs/excel/temp_0d5db55f-4dd6-4a2d-9c46-5205eaf94173.xlsx','application/xlsx','temp_0d5db55f-4dd6-4a2d-9c46-5205eaf94173.xlsx','Ваша таблица заказов, которые в статусе "активный"');
        Bottelegram::sendMessage($user_id, $first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]);//HowToChangePass.MP4//temp_0d5db55f-4dd6-4a2d-9c46-5205eaf94173.xlsx
     break;
     case 'ЗАКАЗАТЬ ТОВАР': Bottelegram::sendMessage($user_id, $first_name.", Пожалуйста выберите категорию товара👇👇👇", [['Женская одежда👩', 'Мужская одежда👦']]); break;
     case 'МУЖСКАЯ ОДЕЖДА👦': Bottelegram::sendMessage($user_id, $first_name.", нам очень жаль😞, но к сожалению в наличие есть только женская одежда, если хотите перейти, то выберите Женская одежда👩 ниже👇👇👇", [['Женская одежда👩', 'Нет']]); break;
     case 'ЖЕНСКАЯ ОДЕЖДА👩': Bottelegram::sendMessage($user_id, $first_name.", Пожалуйста выберите подкатегорию товара👇👇👇", [['Туфли👠', 'Юбка👗'],['Платья👚', 'Джинсы👖']]); break;
     case 'ЮБКА👗': Bottelegram::sendMessage($user_id, $first_name.", нам очень жаль😞, но к сожалению в наличие нет одежды из указанной категории, если хотите посмотреть другие категории, то выберите Женская одежда👩 ниже👇👇👇", [['Женская одежда👩', 'Нет']]); break;
     case 'ПЛАТЬЯ👚': Bottelegram::sendMessage($user_id, $first_name.", нам очень жаль😞, но к сожалению в наличие нет одежды из указанной категории, если хотите посмотреть другие категории, то выберите Женская одежда👩 ниже👇👇👇", [['Женская одежда👩', 'Нет']]); break;
     case 'ДЖИНСЫ👚': Bottelegram::sendMessage($user_id, $first_name.", нам очень жаль😞, но к сожалению в наличие нет одежды из указанной категории, если хотите посмотреть другие категории, то выберите Женская одежда👩 ниже👇👇👇", [['Женская одежда👩', 'Нет']]); break;
     case 'ТУФЛИ👠': Bottelegram::sendMessage($user_id, $first_name.", Пожалуйста выберите цвет товара👇👇👇", [['Белый', 'Черный']]); break;
     case '36':case '37':case '38':case '39': Bottelegram::sendMessagePicture($chat_id,$token,$request->hostInfo.'/web/img/post/2021-L6-CK1-60050953-03-1.jpg','image/jpg','2021-L6-CK1-60050953-03-1.jpg','Туфли итальянские👠👠👠');
        Bottelegram::sendMessage($user_id, $first_name.", Стоимость товара 5000 руб, готовы оплатить?👇👇👇", [['Оплатить', 'Нет']]);
        break;
     case 'БЕЛЫЙ': Bottelegram::sendMessage($user_id, $first_name.", Пожалуйста выберите размер товара👇👇👇", [['36', '37'],['38', '39']]); break;
     case 'ЧЕРНЫЙ': Bottelegram::sendMessage($user_id, $first_name.", нам очень жаль😞, но к сожалению в наличие нет одежды из указанной категории, если хотите посмотреть другие категории, то выберите Женская одежда👩 ниже👇👇👇", [['Туфли👠', 'Нет']]); break;
     case 'ОПЛАТИТЬ': Bottelegram::sendMessage($user_id, $first_name." , Оплата доступна по ссылке 👉👉👉 http://weekcopy.mcdir.ru/  ", [0], ['html', false]); break;
     case 'СТАТУС ЗАКАЗА': Bottelegram::sendMessage($user_id, "Пожалуйста, направьте запрос в следующем формате Номер заказа: номер вашемго заказа. Пример 👉👉👉 НОМЕР ЗАКАЗА: 8defe6ed-af88-456e-8aef-71ff77c9973e", [0], ['html', false]); break;
     case 'НОМЕР ЗАКАЗА': 

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url.'/auth/sign-in');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=&username=sataxa7911%40niback.com&password=a1234567&scope=&client_id=&client_secret=");

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
           
            if (curl_errno($ch)) {
                //return 
                $result = 'Error:' . curl_error($ch);
            }
            else{
                //return $result;
            }
            curl_close($ch);
            $result = json_decode($result, true);
            $access_token = $result["access_token"];
            $user_type = $result["user_type"]; //customer
            $token_type = $result["token_type"]; //bearer




            //$order_id = trim(mb_substr("НОМЕР ЗАКАЗА: 8defe6ed-af88-456e-8aef-71ff77c9973e",14));
            //$order_id = '8defe6ed-af88-456e-8aef-71ff77c9973e';



            /************/

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url.'/order/get_order?order_id='.$order_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Bearer '.$access_token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $error = false;
            if (curl_errno($ch)) {
                $error = 'К сожалению, наше api сейчас недоступно😞, но мы уже работаем над данной проблемой. Ошибка: ' . curl_error($ch);
            }

            curl_close($ch);

            $result = json_decode($result, true);
            $status = $result["status"];
            if(trim($status) == ""){
                $status = 'Заказ '.$order_id." - не найден";
            }
            if($error){
                $status = $error;
            }

         Bottelegram::sendMessage($user_id, "Статус заказа:  ".$status); 
         Bottelegram::sendMessage($user_id, $first_name.", у вас есть еще вопросы?", [['Да', 'Нет']]);
         break;

    default: 
    Yii::$app->db->createCommand()->insert('bot_info', [
                    'platform' => 'telegram',
                    'username' => $username,
                    'first_name' => $first_name,
                    'chat_id' => $chat_id,
                    'user_id' => $user_id,
                    'messange' => $message_original,
                    'chat_time' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'data' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'data_time' => gmdate("Y-m-d\TH:i:s\Z", $chat_time),
                    'answer' => "",
                    'understand' => false,
                ])->execute();
    Bottelegram::sendMessage($user_id, "Неизвестная команда💁, Вы можете написать👉 'старт' для просмотра доступных опций");
}
}

    }

    public function actionSendmail(){
        return $this->render('sendmail');
    }
    public function actionSendmailfile(){
        return $this->render('sendmailfile');
    }
    
    
    
    public function actionLogin(){

        if(  Uservaludate::validateCookie() ){
            $admin = true;
        }
        else{
            $admin = false;
        }
        
        $login_model = new Login();
        
        $errors;
        
        
        if (Yii::$app->request->isPost){
            $_POST = json_decode(file_get_contents('php://input'), true);
            //$2y$10$QxhrMS0wQp32xwLjObr54uZKCKMIWy.Kr6iUQEOgwcLXFQBm/4Fv2

            if($_POST['target'] == 'changepass'){
                $password_new = Uservaludate::validateInput($_POST['password_new']);
                $pass = Uservaludate::validateInput($_POST['password']);
                $cookies = Yii::$app->request->cookies;
                $email = $cookies->get('admin');
                $pr_username = Login::find()->asArray()->where(['username' => $email])->one();

                if(!password_verify($pass, $pr_username['password'])){
                    //return "Некорретный пароль от аккаунта";
                    header('HTTP/1.1 409 Internal Server Booboo');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode(array('message' => 'Некорретный пароль от аккаунта', 'code' => 1337)));
                }
                else{
                    if(strlen($password_new) > 7 && strlen($password_new) < 200){
                        $password_new_generate = password_hash($password_new, PASSWORD_DEFAULT);
                        $update = Login::findone($pr_username['id']);
                        $update->password = $password_new_generate;
                        $update->save(); 
                        return "Пароль успешно изменен";
                    }
                    else{
                        header('HTTP/1.1 409 Internal Server Booboo');
                        header('Content-Type: application/json; charset=UTF-8');
                        die(json_encode(array('message' => 'Пароль должен быть не менее 8 символов', 'code' => 1337)));
                    }
                    
                }

                

                
            }

            if($_POST['target'] == 'signin'){

            

            $email = Uservaludate::validateInput($_POST['email']);
            
            $pass = Uservaludate::validateInput($_POST['password']);

            
            $pr_username = Login::find()->asArray()->where(['username' => $email])->one();
            
            if(empty($pr_username)){
                $errors = "Пользователь ".$email ." не найден";
            }
            else{
                if($pr_username['errors'] >= 5){
                    //$errors = "Повторный пароль выслан на почту";
                    $errors = "Новый пароль выслан Вам на почту, если нет письма, то просьба проверить СПАМ";
                    
                    if(empty($pr_username['code_email'])){
                       $kod_sesi = Uservaludate::generate_code(8);
                     $to  = "<".$email.">" ;

                        $subject = "Ваш новый пароль"; 

                        $message = '
                            <html>
                            <head>
                              <title>Новый пароль:</title>
                            </head>
                            <body>
                              <p>Пароль: '.$kod_sesi.';</p> 
                            </body>
                            </html>
                            ';

                        $headers = 'From: Week@example.com' . "\r\n" .
                        'Content-type: text/html; charset=UTF-8' . "\r\n" .
                        'Reply-To: Week@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                        mail($to, $subject, $message, $headers);
                    
                        $kod_sesi = password_hash($kod_sesi, PASSWORD_DEFAULT);
                    
                        $update = Login::findone($pr_username['id']);
                        $update->password = $kod_sesi;
                        $update->code_email = $kod_sesi;
                        $update->errors = 0;
                        $update->save(); 
                    }
                    else{
                        $errors = "Ваша учетная запись заблокирована, пожлауйста, обратитись к администратору";
                    }
                    
                    
                    
                }
                else{
                  if(!password_verify($pass, $pr_username['password'])){
                        $count_try = 4 - $pr_username['errors'];
                      $up_err = $pr_username['errors'] + 1;
                      $errors = 'Неправильный пароль, оставшееся кол-во попыток: '.$count_try;
                      $update = Login::findone($pr_username['id']);
                      $update->errors = $up_err;
                      $update->save();
                      
                }  
                }
                
            }


            if(empty($errors)){
                
            
            
            
                if( empty($errors) ){  //save()

                        $name = 'admin';


                        // Костыль
                        if($pr_username['username'] == 'julia.anderson@mail.com' || $pr_username['username'] == '12021970e@gmail.com'){
                                $name = 'moderator';
                        }



                      

                        $cookies = Yii::$app->response->cookies;
                    
                        $cookies->add( new \yii\web\Cookie([
                            'name' => $name,
                            'value' => $pr_username['username'],
                            'expire' => time() + 86400 * 365,
                        ]));
                         $cookies->add( new \yii\web\Cookie([
                            'name' => 'auth_key',
                            'value' => $pr_username['auth_key'],
                            'expire' => time() + 86400 * 365,
                        ]));
                    
                        $update = Login::findone($pr_username['id']);
                        $update->errors = 0;
                        $update->code_email = '';
                        $update->save();
                        //return $this->redirect('/');
                        return 'Данные приняты';
                    }
                    else
                    {
                        
                        
                        return $errors;
                    }
            }
            elseif($errors == "Повторный пароль выслан на почту" && !empty($pr_username['code_email'])){
               $pr_username = Login::find()->asArray()->where(['username' => $email])->one();
                if(password_verify($pass, $pr_username['code_email'])){
                   
                        $cookies = Yii::$app->response->cookies;


                        $name = 'admin';

                        if($pr_username['username'] == 'julia.anderson@mail.com' || $pr_username['username'] == '12021970e@gmail.com'){
                                $name = 'moderator';
                        }
                    
                        $cookies->add( new \yii\web\Cookie([
                            'name' => $name,
                            'value' => $pr_username['username'],
                            'expire' => time() + 86400 * 365,
                        ]));
                         $cookies->add( new \yii\web\Cookie([
                            'name' => 'auth_key',
                            'value' => $pr_username['auth_key'],
                            'expire' => time() + 86400 * 365,
                        ]));
                    
                        $update = Login::findone($pr_username['id']);
                        $update->errors = 0;
                        $update->code_email = '';
                        $update->save();
                        //return $this->redirect('/');
                        return 'Данные приняты';
                }
                else{
                    return 'Код не совпадает с высланным на почту';
                }
            }
            else{
                 //return $errors;
                header('HTTP/1.1 409 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => $errors, 'code' => 1337)));
            }
            }

        }
        
        
        if($login_model->load(Yii::$app->request->post())){
            
            
            $email = Uservaludate::validateInput($login_model->username);
            
            $pass = Uservaludate::validateInput($login_model->password);
            
            $pr_username = Login::find()->asArray()->where(['username' => $email])->one();
            
            if(empty($pr_username)){
                $errors = "Пользователь ".$email ." не найден";
            }
            else{
                if($pr_username['errors'] >= 5){
                    $errors = "Повторный пароль выслан на почту";
                    
                    if(empty($pr_username['code_email'])){
                       $kod_sesi = Uservaludate::generate_code(5);
                     $to  = "<".$email.">" ;

                        $subject = "Код подтверждения"; 

                        $message = '
                            <html>
                            <head>
                              <title>Ваш код:</title>
                            </head>
                            <body>
                              <p>Код: '.$kod_sesi.';</p> 
                            </body>
                            </html>
                            ';

                        $headers = 'From: PawLeashClub@example.com' . "\r\n" .
                        'Content-type: text/html; charset=UTF-8' . "\r\n" .
                        'Reply-To: PawLeashClub@example.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                        mail($to, $subject, $message, $headers);
                    
                        $kod_sesi = password_hash($kod_sesi, PASSWORD_DEFAULT);
                    
                        $update = Login::findone($pr_username['id']);
                        $update->code_email = $kod_sesi;
                        $update->save(); 
                    }
                    
                    
                    
                }
                else{
                  if(!password_verify($pass, $pr_username['password'])){
                      $up_err = $pr_username['errors'] + 1;
                      $errors = 'Неправильный пароль';
                      $update = Login::findone($pr_username['id']);
                      $update->errors = $up_err;
                      $update->save();
                      
                }  
                }
                
            }
            
            
            if(empty($errors)){
                
            
            
            
                if( $login_model->validate() ){  //save()

                        $name = 'admin';


                        // Костыль
                        if($pr_username['username'] == 'julia.anderson@mail.com' || $pr_username['username'] == '12021970e@gmail.com'){
                                $name = 'moderator';
                        }



                        Yii::$app->session->setFlash('success', 'Данные приняты');

                        $cookies = Yii::$app->response->cookies;
                    
                        $cookies->add( new \yii\web\Cookie([
                            'name' => $name,
                            'value' => $pr_username['username'],
                            'expire' => time() + 86400 * 365,
                        ]));
                         $cookies->add( new \yii\web\Cookie([
                            'name' => 'auth_key',
                            'value' => $pr_username['auth_key'],
                            'expire' => time() + 86400 * 365,
                        ]));
                    
                        $update = Login::findone($pr_username['id']);
                        $update->errors = 0;
                        $update->code_email = '';
                        $update->save();
                        return $this->redirect('/');
                    }
                    else
                    {
                        
                        foreach ($login_model->getErrors() as $key => $value) {
                        $error_arr =  $key.': '.$value[0];
                      }
                        Yii::$app->session->setFlash('error', $error_arr);
                    }
            }
            elseif($errors == "Повторный пароль выслан на почту" && !empty($pr_username['code_email'])){
               $pr_username = Login::find()->asArray()->where(['username' => $email])->one();
                if(password_verify($pass, $pr_username['code_email'])){
                    Yii::$app->session->setFlash('success', 'Данные приняты');
                        $cookies = Yii::$app->response->cookies;


                        $name = 'admin';

                        if($pr_username['username'] == 'julia.anderson@mail.com' || $pr_username['username'] == '12021970e@gmail.com'){
                                $name = 'moderator';
                        }
                    
                        $cookies->add( new \yii\web\Cookie([
                            'name' => $name,
                            'value' => $pr_username['username'],
                            'expire' => time() + 86400 * 365,
                        ]));
                         $cookies->add( new \yii\web\Cookie([
                            'name' => 'auth_key',
                            'value' => $pr_username['auth_key'],
                            'expire' => time() + 86400 * 365,
                        ]));
                    
                        $update = Login::findone($pr_username['id']);
                        $update->errors = 0;
                        $update->code_email = '';
                        $update->save();
                        return $this->redirect('/');
                }
                else{
                    Yii::$app->session->setFlash('error', "Код не совпадает с высланным на почту");
                }
            }
            else{
                 Yii::$app->session->setFlash('error', $errors);
            }
            
            
            
        }

        if(!$admin){
            return $this->render('login', compact('login_model'));
        }
        else{
            return $this->redirect('/');
        }
        
        
    }
    
    
    
    
}