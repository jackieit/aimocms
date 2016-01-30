<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

class WebUploaderAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
    public $css = [
        'css/webuploader.css'
    ];
    public $js = [
        'js/webuploader/webuploader.min.js',
        'js/webuploader/upload.js',
    ];

    public $depends = [
        'yii\web\JQueryAsset'
    ];
}
