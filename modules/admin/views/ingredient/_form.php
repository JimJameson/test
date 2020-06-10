<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'is_hidden')->dropDownList(['Нет', 'Да']) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
