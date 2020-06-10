<?php

/* @var $this yii\web\View */
/* @var $ingredients \app\models\Ingredient[] */

use kartik\select2\Select2;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Укажите ингредиенты для поиска блюд</p>

        <div class="row">
            <div class="col-md-11">

                <?php
                    echo Select2::widget([
                        'name' => 'state_1',
                        'value' => '',
                        'data' => $ingredients,
                        'options' => ['multiple' => true, 'placeholder' => 'Выберите ингредиенты ...'],
                        'pluginOptions' => ['maximumSelectionLength' => 5],
                ]);
                ?>
            </div>
            <div class="col-md-1">
                <?= \yii\helpers\Html::button('Найти', ['class' => 'btn btn-success search-dishes']) ?>
            </div>
        </div>
    </div>

    <div class="body-content">


    </div>
</div>
