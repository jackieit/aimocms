<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;


defined('FORCE') or define('FORCE', (YII_ENV == 'dev')?true:false);


class AppAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
   // public $baseUrl = '@web';
    public $css = [
        'css/sb-admin-2.css',
        'css/site.css',
    ];
    public $js = [
        'js/sb-admin-2.js',
    ];

    public $publishOptions = ['forceCopy' => FORCE];

    public $depends = [
        'yii\web\JQueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\MetisMenuAsset',
        'backend\assets\FontAwesomeAsset',

    ];
}
