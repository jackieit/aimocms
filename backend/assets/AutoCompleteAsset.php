<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;


defined('FORCE') or define('FORCE', (YII_ENV == 'dev')?true:false);


class AutoCompleteAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
   // public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/jquery.autocomplete.min.js',
    ];

    public $publishOptions = ['forceCopy' => FORCE];

    public $depends = [
        'yii\web\JQueryAsset'
    ];
}
