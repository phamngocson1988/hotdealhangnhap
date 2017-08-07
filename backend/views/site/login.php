<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div>
  <div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
          <h1>Login Form</h1>
          <?= $form->field($model, 'username', [
            'template' => "{input}{error}",
          ])->textInput(['autofocus' => true, 'class' => 'form-control', 'placeholder' => 'Username']) ?>

          <?= $form->field($model, 'password', [
            'template' => "{input}{error}",
          ])->passwordInput(['class' => 'form-control', 'placeholder' => 'Password']) ?>

          <div>
            <?= Html::submitButton('Login', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
          </div>
          <div class="clearfix"></div>

          <div class="separator">

            <div class="clearfix"></div>
            <br />

            <div>
              <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
              <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
            </div>
          </div>
        <?php ActiveForm::end(); ?>
      </section>
    </div>
  </div>
</div>
