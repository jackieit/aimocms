<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

class DatetimeAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';

    public $css = [
        'css/bootstrap-datetimepicker.min.css'
    ];
    public $js = [
        'js/moment.min.js',
        'js/bootstrap-datetimepicker.min.js',
    ];

    public $depends = [
        'yii\web\JQueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
