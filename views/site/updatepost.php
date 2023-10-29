<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>

    <?
   /* $cookies = Yii::$app->response->cookies;
                    
                        $cookies->add( new \yii\web\Cookie([
                            'name' => '_csrf',
                            'value' => $csrf_token = Yii::$app->request->csrfToken,
                            'expire' => time() + 86400 * 365,
                        ]));*/

    $csrf_param = Yii::$app->request->csrfParam; 
    $csrf_token = Yii::$app->request->csrfToken;
?>
<input id="token" style="display: none" type="text" value="<?=$csrf_token?>">

<div class="container mt-5 pt-5">
<form onsubmit="return false">

  <div class="mb-3">
    <label for="title" class="form-label">Название</label>
    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" v-model="title" maxlength="255" placeholder="Введите название">
  </div>

  <div class="mb-3">
  <label for="editFormControlTextarea1" class="form-label">Описание</label>
  <textarea class="form-control" id="editFormControlTextarea1" rows="3" v-model="text" placeholder="Введите описание" maxlength="15000">
    
  </textarea>
</div>

 <div class="form-group mt-5">
    <label for="file">Example file input</label>
    <input type="file" class="form-control-file" id="file" accept="image/*">
  </div>
  <div v-if="load" class="spinner-border text-primary mb-2" role="status">
  <span class="visually-hidden">Загрузка...</span>
</div>
  <button type="submit" id="send_file" v-on:click="uploadpost" class="btn btn-primary mt-2 mb-5">Загрузить на сервер</button>
</form>
</div>
</main>