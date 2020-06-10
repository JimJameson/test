<?php

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dish-view">

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить это блюдо?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>
    <h3>Ингредиенты</h3>
    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <?php foreach ($model->dishesIngredients as $dishIngredient): ?>
            <tr>
                <td><?= $dishIngredient->ingredients->name ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>
