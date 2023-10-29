<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap5.min.css',
        //'css/animate.css',
        'css/style.css?v1.018',
        'css/responsive.css?v1.018',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css',
        //'css/style.sass',
        //'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css',
        

    ];
    public $js = [
        'web/axios/dist/axios.min.js',
        'js/bootstrap5.bundle.min.js',
        'web/chars/loader.js',
        'js/vue.global.prod.min.js',
        'https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js',
        'js/main_vue3.js?v1.019',
        //'https://cdnjs.cloudflare.com/ajax/libs/fetch/3.6.2/fetch.min.js'
        //'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
        
    ];
    
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
