<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

class SortableListAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets/dist';
   // public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/jquery.sortable-lists.min.js',
    ];

    public $depends = [
        'yii\web\JQueryAsset'
    ];
}
