<?php

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $form yii\widgets\ActiveForm */

use app\models\Event;
use app\models\Item;
use app\models\Task;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($model->isNewRecord) {
    $model->active = true;
}
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <h2>Основное</h2>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type')->dropDownList(Task::getTypes(), [
                'prompt' => '--- выберите тип ---'
            ]) ?>

            <?= $form->field($model, 'active')->checkbox() ?>
        </div>
        <div class="col-sm-4">
            <h2>Выполнить</h2>

            <?= $form->field($model, 'item_id')->widget(Select2::className(), [
                'data' => Item::getList(true),
                'options' => [
                    'placeholder' => 'Выберите элемент ...',
                ],
            ]) ?>

            <?= $form->field($model, 'item_value')->textInput(['maxlength' => true]) ?>

            <p>или:</p>

            <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
        </div>
        <div class="col-sm-4">
            <h2>События</h2>

            <?= $form->field($model, 'event_ids')->widget(Select2::className(), [
                'data' => Event::getList(),
                'showToggleAll' => false,
                'options' => [
                    'placeholder' => 'Выберите события ...',
                    'multiple' => true,
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?php if ($model->isNewRecord): ?>
            <?= Html::submitButton('Добавить и посмотреть', ['class' => 'btn btn-success', 'name' => 'after', 'value' => 'view']) ?>
            <?= Html::submitButton('Добавить и добавить еще', ['class' => 'btn btn-success', 'name' => 'after', 'value' => 'add-another']) ?>
            <?= Html::submitButton('Добавить и вернутся', ['class' => 'btn btn-success', 'name' => 'after', 'value' => 'return']) ?>
        <?php else: ?>
            <?= Html::submitButton('Сохранить и посмотреть', ['class' => 'btn btn-primary', 'name' => 'after', 'value' => 'view']) ?>
            <?= Html::submitButton('Сохранить и добавить еще', ['class' => 'btn btn-primary', 'name' => 'after', 'value' => 'add-another']) ?>
            <?= Html::submitButton('Сохранить и вернутся', ['class' => 'btn btn-primary', 'name' => 'after', 'value' => 'return']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
