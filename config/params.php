<?php

use yii\helpers\ArrayHelper;

$params = [
    'adminEmail' => 'admin@example.com',
    'wsURL' => 'ws://192.168.1.111:8081',
    'pushAllID' => '38678',
    'pushAllKey' => '83a29d6a4bb068458d375daaa16039c4',
];

return ArrayHelper::merge($params, require 'params-local.php');
