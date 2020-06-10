<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $modelsIngredient app\models\DishIngredient[] */
/* @var $form yii\widgets\ActiveForm */
/* @var $ingredients \app\models\Ingredient[] */
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <div class="panel panel-default">
        <div class="panel-heading"><h4>Ингредиенты</h4></div>
        <div class="panel-body">

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
//                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsIngredient[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'ingredients_id',
                    'dishes_id',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsIngredient as $i => $modelIngredient): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
//                            if (! $modelIngredient->isNewRecord) {
//                                echo Html::activeHiddenInput($modelIngredient, "[{$i}]id");
//                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($modelIngredient, "[{$i}]ingredients_id")->widget(\kartik\select2\Select2::class, [
                                        'data' => $ingredients,
                                        'language' => 'ru',
                                        'options' => ['placeholder' => 'Выберите ингредиент'],
                                    ])
                                    ->label('')?>
                                </div>
                            </div>
<!--                            --><?//= $form->field($modelIngredient, "[{$i}]dishes_id",[
//                                    'inputOptions' => [
//                                            'value' => $model->id,
//                                            'class' => 'input-dishes_id',
//                                    ]])
//                                ->hiddenInput()->label('') ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>

