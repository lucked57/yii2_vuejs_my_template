<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;


    $csrf_param = Yii::$app->request->csrfParam; 
    $csrf_token = Yii::$app->request->csrfToken;
?>
<input id="token" style="display: none" type="text" value="<?=$csrf_token?>">

<div class="container mt-5 pt-5">
<form onsubmit="return false">

  <div class="mb-3">
    <label for="name" class="form-label">Ваше имя</label>
    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" v-model="name" maxlength="255" placeholder="Введите название">
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Ваше email</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="email" maxlength="255" placeholder="Введите название">
  </div>

  <div class="mb-3">
    <label for="subject" class="form-label">Тема</label>
    <input type="text" class="form-control" id="subject" aria-describedby="emailHelp" v-model="subject" maxlength="255" placeholder="Введите название">
  </div>

  <div class="mb-3">
  <label for="editFormControlTextarea1" class="form-label">Описание</label>
  <textarea class="form-control" id="editFormControlTextarea1" rows="3" v-model="text" placeholder="Введите описание" maxlength="15000">
    
  </textarea>
</div>

  <div v-if="load" class="spinner-border text-primary mb-2" role="status">
  <span class="visually-hidden">Загрузка...</span>
</div>
  <button type="submit" id="send_file" v-on:click="Sendemail" class="btn btn-primary mt-2 mb-5">Отправить</button>
</form>
</div>
</main>