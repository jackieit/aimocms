<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;


class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    //public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
    ];
    public $js = [
     ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
