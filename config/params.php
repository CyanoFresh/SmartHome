<?php

use yii\helpers\ArrayHelper;

$params = [
    'adminEmail' => 'admin@example.com',
    'wsURL' => 'ws://192.168.1.102:8081',
];

return ArrayHelper::merge($params, require 'params-local.php');
