<?php
/** @var \app\models\LoginForm $model */
?>

<div class="login-box">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = \yii\widgets\ActiveForm::begin() ?>
        <?= $form->field($model, 'username',
        )->textInput(['placeholder' => 'Login']) ?>
        <?= $form->field($model, 'password',
        )->passwordInput(['placeholder' => 'Password']) ?>
        <div class="col-4">
            <?= \yii\helpers\Html::submitButton('Login',['class' => 'btn btn-primary btn-block']) ?>
        </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
</div>

