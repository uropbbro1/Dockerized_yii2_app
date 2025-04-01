<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
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
        'css/base.css',
        'css/header.css',
        'css/menu.css',
        'css/footer.css',
        'css/popup.css',
        'css/comments.css',
        'css/profile.css',
    ];
    public $js = [
        'https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js',
        'js/base.js',
        'js/comments.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
