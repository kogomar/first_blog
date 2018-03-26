<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form ActiveForm */
?>
<div class="main-profile">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fullname') ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton('Edit Profile', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- main-profile -->
