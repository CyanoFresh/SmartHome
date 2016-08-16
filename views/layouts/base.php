<?php

/* @var $this \yii\web\View */
/* @var $content string */

use dmstr\helpers\AdminLteHelper;
use dmstr\web\AdminLteAsset;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>

    <title><?= $this->title ?> - <?= Yii::$app->name ?></title>

    <?php $this->head() ?>
</head>

<body class="hold-transition <?= AdminLteHelper::skinClass() ?> <?= $this->params['body-class'] ?> sidebar-mini">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
