<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
    public $css = [

    ];
    public $js = [
        'js/jqColorPicker.min.js',
     ];

    public $depends = [
        'yii\web\JQueryAsset'
    ];
}
