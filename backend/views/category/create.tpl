{use class='yii\helpers\Html'}
{use class='yii\widgets\ActiveForm' type='block'}
<div class="site-signup">
  <h1>Create</h1>

  <p>Category:</p>

  <div class="row">
    <div class="col-lg-5">
      {ActiveForm assign='form'}
        {$form->field($model, 'id')->hiddenInput()->label(false)}
        {$form->field($model, 'name')->textInput(['autofocus' => true])}
        {$form->field($model, 'slug')}
        <div class="form-group">
        {Html::resetButton('Reset', ['class' => 'btn btn-default'])}
        {Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'signup-button'])}
        </div>

      {/ActiveForm}
    </div>
  </div>
</div>
