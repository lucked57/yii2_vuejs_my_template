<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>
    <div class="container">
        <!--<h1 class="mt-5 text-center">Авторизация</h1>-->
        

        <?php if( Yii::$app->session->hasFlash('success') ):?>
    
    <div class="alert alert-success alert-dismissible fade show" role="alert">
   <?php echo Yii::$app->session->getFlash('success'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

    <?php endif;?>
    
    
    
    <?php if( Yii::$app->session->hasFlash('error') ):?>
    
       <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <?php echo Yii::$app->session->getFlash('error'); ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

    <?php endif;?>
        
       <!-- <?php $form = ActiveForm::begin([
    'id' => 'loginForm',
]) ?>
            <?= $form->field($login_model, 'username')->input('email') ?>
            <?= $form->field($login_model, 'password')->input('password') ?>
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>-->
        
      


<div class="form-data">
                    <div class="text-center my-5 pt-5">
                        <h4>Авторизация</h4>
                    </div>
                    <div class="row">
                         
                    <div class="col-md-4 d-none d-md-block"></div>
                    <div class="col-md-4">
                        <div :disabled='isDisabled' class="forms-inputs mb-4"> <span>Почта</span> <input type="text" v-model="email" v-bind:class="{'form-control':true, 'is-invalid' : (!validEmail(email) && emailBlured) || (error && emailBlured)}" v-on:blur="emailBlured = true">
                        <div class="invalid-feedback">{{email_error}}</div>
                    </div>
                    <div :disabled='isDisabled' class="forms-inputs mb-4"> <span>Пароль</span> <input type="password" v-model="password" v-bind:class="{'form-control':true, 'is-invalid' : (!validPassword(password) && passwordBlured) || (error && passwordBlured)}" v-on:blur="passwordBlured = true">
                        <div class="invalid-feedback">{{password_error}}</div>
                    </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block"></div>
                    </div>
                   
                    <div class="mb-3 text-center"> <button :disabled='isDisabled' @click="submitsignin" class="btn btn-dark px-5 py-2">Войти</button> </div>
                </div>
               



    </div>
</main>