<?php

/** @var $dishes \app\models\DishIngredient[] */
/** @var $coincidences int */
?>
<h3><?= $coincidences ?? '' ?></h3>
<?php foreach ($dishes as $dish): ?>
<div class="row">
    <div class="col-md-12">
        <p><?= $dish->dishes->name ?></p>
    </div>
</div>
<?php endforeach; ?>