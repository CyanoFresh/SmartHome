<?php

namespace app\assets;

use yii\web\AssetBundle;

class PanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/panel.css',
    ];
    public $js = [
        'js/panel.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
        'app\assets\HandlebarsAsset',
        'app\assets\SpectrumAsset',
        'app\assets\ChartjsAsset',
        'yii\web\JqueryAsset',
    ];
}
