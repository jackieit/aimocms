<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MetisMenuAsset extends AssetBundle
{
    public $basePath = '@bower/metisMenu/dist';
    public $baseUrl = '@web';
    public $css = [
        'metisMenu.min.css',
    ];
    public $js = [
        'metisMenu.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
