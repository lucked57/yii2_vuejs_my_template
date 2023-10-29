<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $csrf_param = Yii::$app->request->csrfParam; 
    $csrf_token = Yii::$app->request->csrfToken;
?>
<input id="token" style="display: none" type="text" value="<?=$csrf_token?>">

<div class="container mt-5 pt-5">
<form onsubmit="return false">

 
 <div class="form-group mt-5">
    <label for="file">Example file input</label>
    <input type="file" class="form-control-file" id="file" accept="image/*">
  </div>
  <div v-if="load" class="spinner-border text-primary mb-2" role="status">
  <span class="visually-hidden">Загрузка...</span>
</div>
  <button type="submit" id="send_file" v-on:click="uploadphoto" class="btn btn-primary mt-2 mb-5">Загрузить на сервер</button>
</form>
</div>
</main>