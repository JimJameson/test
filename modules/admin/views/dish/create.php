<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $modelsIngredient \app\models\DishIngredient[] */
/* @var $ingredients \app\models\Ingredient[] */

$this->title = 'Добавление блюда';
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsIngredient' => $modelsIngredient,
        'ingredients' => $ingredients,
    ]) ?>

</div>
