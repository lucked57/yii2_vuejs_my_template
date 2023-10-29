<?php

namespace app\components;

use Yii;
use app\models\Login;

class Uservaludate{
    
      public static function validateInput($arr){
        
        $arr = str_replace("'", "", $arr);
        
        $arr = str_replace("<", "", $arr);

        $arr = str_replace(">", "", $arr);
        
        return $arr;
    }
    
    public static function validateCookie(){

        $cookies = Yii::$app->request->cookies;



        if (($cookie = $cookies->get('admin')) !== null) {
            $email = $cookie->value;
            $pr_admin = Login::find()->asArray()->where(['username' => $email])->one();
        }
        if (($cookie = $cookies->get('auth_key')) !== null) {
            $auth_key = $cookie->value;
        }




        if(!empty($pr_admin)){
            if(strcasecmp($pr_admin['auth_key'], $auth_key) == 0){
            return true;
        }
            else{
                return false;
            }
        }
    }






    public static function validateCookieModerator(){

        $cookies = Yii::$app->request->cookies;



        if (($cookie = $cookies->get('moderator')) !== null) {
            $email = $cookie->value;
            $pr_admin = Login::find()->asArray()->where(['username' => $email])->one();
        }
        if (($cookie = $cookies->get('auth_key')) !== null) {
            $auth_key = $cookie->value;
        }




        if(!empty($pr_admin)){
            if(strcasecmp($pr_admin['auth_key'], $auth_key) == 0){
            return true;
        }
            else{
                return false;
            }
        }
    }
    
    
    public static function CookieLang(){
        
            $cookies = Yii::$app->request->cookies;

            if (($cookie = $cookies->get('lang')) == null) {
               $lang = 'ru';
            }
            else{
                $lang = $cookie->value;
            }
                return $lang;
    }
    
        public static function generate_code($len)
        {
            $string = '';

            $chars = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM9876543210';

            $num_chars = strlen($chars);

            for ($i = 0; $i < $len; $i++)
            {
                $string .= substr($chars, rand(1,$num_chars)-1, 1);
            }
            return $string;

        }
        public static function routing_lang(){
            $url      = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $validURL = str_replace("&", "&amp", $url);

            $pos      = strripos($validURL, '/ee');

            if ($pos === false) {
                $lang = 'ru';
            } else {
                $lang = 'ee';
            }
             $cookies = Yii::$app->response->cookies;
                        $cookies->add( new \yii\web\Cookie([
                                'name' => 'lang',
                                'value' => $lang,
                                'expire' => time() + 86400 * 365,
                            ]));
            Yii::$app->params['lang'] = $lang;
            return $lang;
        }
    
}