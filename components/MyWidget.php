<?php

namespace app\components;

use yii\base\Widget;

class MyWidget extends Widget{
    
    public $name;
    
    public function init(){ //проверка параметров(например $name)
        parent::init();
        if( $this->name === null){
            $this->name = "Гость";
        }
    }
    
    public function run(){
        return $this->render('my', ['name' => $this->name]);
    }
    
}


?>