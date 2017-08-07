{use class='yii\helpers\Html'}
{use class='yii\widgets\ActiveForm' type='block'}
{use class='yii\helpers\ArrayHelper'}
<div class="page-title">
  <div class="title_left">
    <h3>Create new customer</h3>
  </div>
</div>

<div class="clearfix"></div>

{ActiveForm assign='form'}
{$form->field($model, 'id')->hiddenInput()->label(false)}
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Customer</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        
        {$form->field($model, 'email', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Email'],
          'template' => '{input}<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'name', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Name'],
          'template' => '{input}<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'phone', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Phone'],
          'template' => '{input}<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'address', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Address'],
          'template' => '{input}<span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'facebook', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Facebook'],
          'template' => '{input}<span class="fa fa-facebook form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'note', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Note'],
          'template' => '{input}<span class="fa fa-sticky-note form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}
      </div>
    </div>
    
    <div class="x_panel">
      <div class="x_content">
        <div class="row">
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</div>
{/ActiveForm}
{registerJs}

{/registerJs}