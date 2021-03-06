<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

//defined('FORCE') or define('FORCE', (YII_ENV == 'dev')?true:false);


class TinyMceAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
    public $css = [

    ];
    public $js = [
        'js/tinymce/tinymce.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];
    //public $publishOptions = ['forceCopy' => FORCE];

    public $depends = [
        'yii\web\JQueryAsset'
    ];
}
