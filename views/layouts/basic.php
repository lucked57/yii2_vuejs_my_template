<?php

use app\assets\MyClassAsset;

use yii\helpers\Html;

MyClassAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
   <?php $this->beginBody() ?>
    <!--<div class="wrap">
        
        <div class="container">
            <ul class="nav nav-pills">
              <li class="active"><?= Html::a('Главная','/web/') ?></li>
              <li><?= Html::a('Статьи',['post/index']) ?></li>
              <li><?= Html::a('Статья',['post/show']) ?></li>
            </ul>
            <?php if( isset($this->blocks['block1']) ):?>
                <?php echo $this->blocks['block1']; ?>
            <?php endif;?>
             <?= $content ?>
        </div>
        
    </div>-->
    
    
    
    
    
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top"> <!--sticky-top -->
    <div id="navbar-brand">
	    <a class="navbar-brand text-white">
	        <span class="fa fa-paw"></span>
	        <span>NameSayt</span>
	    </a>
	    </div>
	    <button style="border:none;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="toggle navigations">
	        <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent" >
	            <ul class="navbar-nav mr-auto">
	                <li class="nav-item">
	                   <?= Html::a('Главная','/', ['class' => 'nav-link']) ?>
	                </li>
	                <li class="nav-item">
	                    <?= Html::a('Статьи',['post/index'], ['class' => 'nav-link']) ?>
	                </li>
	                <li class="nav-item">
	                    <?= Html::a('Статья',['post/show'], ['class' => 'nav-link']) ?>
	                </li>
	            </ul>
	    </div>
	</nav>
          <div class="container mt-5">
              <?= $content ?>
          </div>
   
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>