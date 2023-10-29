<?php

use app\assets\AppAsset;

use yii\helpers\Html;
use app\models\Login;
use app\components\Uservaludate;

$login_model = new Login();

$now = new DateTime();
$current_year = substr($now->format('Y-m-d H:i:s'), 0, 4);
                    

$isAdmin = false;

$cookies = Yii::$app->request->cookies;

if(empty(Yii::$app->params['lang'])){
    $lang = Uservaludate::CookieLang();
}
else{
    $lang = Yii::$app->params['lang'];
}

if($lang == 'ru'){
    $main = 'Главная';
    $service = 'Админ';
    $gallery = 'Галерея';
    $calendar = 'Расписание';
    $article = 'Статьи';
    $contact = 'Контакты';
    $regulations = 'Правила';
    $video = 'Видео';
    $port = 'Портфолио';
    $sendmail = 'Почта';
    $sendmailfile = 'Почта файл';
}
else{
    $main = 'Peamine';
    $service = 'Teenused';
    $gallery = 'Galerii';
    $calendar = 'Kalender';
    $article = 'Artiklid';
    $contact = 'Kontakt';
    $regulations = 'eeskirjadega';
    $video = 'Video';
    $port = 'Portfolio';
}


if($lang == 'ee'){
    $add = '/ee';
}
else{
    $add = '';
}


////////админ
if (($cookie = $cookies->get('admin')) !== null) {
    $email = $cookie->value;
    $pr_admin = Login::find()->asArray()->where(['username' => $email])->one();
}
if (($cookie = $cookies->get('auth_key')) !== null) {
    $auth_key = $cookie->value;
}




if(!empty($pr_admin)){
    if(strcasecmp($pr_admin['auth_key'], $auth_key) == 0){
    $isAdmin = true;
}
}

$isModerator = false;
$pr_moderator = false;

/////модератор
if (($cookie = $cookies->get('moderator')) !== null) {
    $email = $cookie->value;
    $pr_moderator = Login::find()->asArray()->where(['username' => $email])->one();
}
if (($cookie = $cookies->get('auth_key')) !== null) {
    $auth_key = $cookie->value;
}


if(!empty($pr_moderator)){
    if(strcasecmp($pr_moderator['auth_key'], $auth_key) == 0){
    $isModerator = true;
}
}



AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="yff5zm2oaM_IAfG7ARFyCbYEnskO4b1jPXs6ZTWWi4g" />
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
  <link rel="shortcut icon" href="../web/logo_new.ico" type="image/x-icon">
</head>
<body>
   <?php $this->beginBody() ?>

    <main id="app">

      <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editmodalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
  <label for="editFormControlTextarea1" class="form-label">Изменить</label>
  <textarea class="form-control" id="editFormControlTextarea1" rows="3" v-model="edittext">
    
  </textarea>
</div>
      </div>
      <div class="modal-footer">
        <button id="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        <button id="save" type="button" class="btn btn-primary" v-on:click="editaxios">Сохранить</button>
      </div>
    </div>
  </div>
</div>  
    
   <header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Week Stats</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php if($isAdmin == true): ?>
  <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Поиск" aria-label="Search">-->
  <div class="w-100">Week bot</div>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="/site/logexit">Выйти</a>
    </div>
  </div>
<?php endif; ?>
</header>
    
    <?php if($isAdmin == true): ?> 
 <div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Главная
            </a>
          </li>
          <li class="nav-item" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Сменить пароль
          
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file"></span>
              Telegram
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="shopping-cart"></span>
              Week Seller
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              Week Buyer
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Week WEB
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Запросы
            </a>
          </li>
        </ul>

       <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>-->
      </div>
    </nav>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Смена пароля</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div :disabled='isDisabled' class="forms-inputs mb-4"> <span>Ваш текущий пароль</span> <input type="password" v-model="password" v-bind:class="{'form-control':true, 'is-invalid' : (!validPassword(password) && passwordBlured) || (error && passwordBlured)}" v-on:blur="passwordBlured = true">
                        <div class="invalid-feedback">{{password_error}}</div>
                    </div>

                    <div :disabled='isDisabled' class="forms-inputs mb-4"> <span>Новый пароль</span> <input type="password" v-model="passwordchange" v-bind:class="{'form-control':true, 'is-invalid' : (!validPassword(passwordchange) && passwordchangeBlured) || (error && passwordchangeBlured)}" v-on:blur="passwordchangeBlured = true">
                        <div class="invalid-feedback">{{password_error}}</div>
                    </div>

                    <div :disabled='isDisabled' class="forms-inputs mb-4"> <span>Новый пароль повторно</span> <input type="password" v-model="passwordchangeagain" v-bind:class="{'form-control':true, 'is-invalid' : (!validPassword(passwordchangeagain) && passwordchangeagainBlured) || (error && passwordchangeagainBlured)}" v-on:blur="passwordchangeagainBlured = true">
                        <div class="invalid-feedback">{{password_error}}</div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-dark" :disabled='isDisabled' @click="changepass">Сменить</button>
      </div>
    </div>
  </div>
</div>
        
        <?php endif; ?>
        
            
        <div class="modal-menu"></div>
        
        
        
             
                  <?= $content ?>
              
      
    <?php $this->endBody() ?>
   <!-- Footer -->



  
</body>
</html>
<?php $this->endPage() ?>
