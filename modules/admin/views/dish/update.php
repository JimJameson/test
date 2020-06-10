<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $modelsIngredient \app\models\DishIngredient[] */
/* @var $ingredients \app\models\Ingredient[] */

$this->title = 'Редактирование блюда: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="dish-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsIngredient' => $modelsIngredient,
        'ingredients' => $ingredients,
    ]) ?>


</div>
