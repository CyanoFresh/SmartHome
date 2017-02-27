<?php

/* @var $this yii\web\View */
/* @var $item \app\models\Item */

use rmrevin\yii\fontawesome\FA;

?>

<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="panel-item panel-item-rgb withripple <?= $item->class ?>" data-item-id="<?= $item->id ?>">
        <div class="panel-item-rgb-icon">
            <?= FA::i($item->icon) ?>
        </div>
        <div class="panel-item-rgb-name">
            <?= $item->name ?>
        </div>
    </div>
</div>
