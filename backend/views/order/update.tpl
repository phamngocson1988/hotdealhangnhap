{use class='yii\helpers\Html'}
{use class='yii\widgets\ActiveForm' type='block'}
{use class='yii\helpers\ArrayHelper'}
<div class="page-title">
  <div class="title_left">
    <h3>Update Order</h3>
  </div>
</div>

<div class="clearfix"></div>

{ActiveForm assign='form'}
{$form->field($model, 'id')->hiddenInput()->label(false)}
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="bs-docs-section">
        <h3 id="glyphicons" class="page-header">Customer</h3>
        {$customer = $model->getCustomer()}
        <b>Name:</b> {$customer->name} <br/>
        <b>Email:</b> {$customer->email} <br/>
        <b>Address:</b> {$customer->address} <br/>
        <b>Phone:</b> {$customer->phone} <br/>
        <b>Facebook:</b> {$customer->facebook} <br/>
      </div>
    </div>

    <div class="x_panel">
      <div class="x_title">
        <h2>Description</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        {$form->field($model, 'description', [
          'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Description for order'],
          'template' => '{error}{hint}{input}'
        ])->textarea()}

        {$form->field($model, 'prepay', [
          'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Prepay', 'role' => 'number'],
          'template' => '{input}<span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}
      </div>
    </div>
    {foreach $model->getItems() as $item}
    <div class="x_panel item">
      <div class="x_title">
        <h2>Item</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="form-group">
          {$form->field($model, 'item_id[]', [
            'inputOptions' => ['value' => $item->id]
          ])->hiddenInput()->label(false)}

          {$form->field($model, 'item_link[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Link', 'value' => $item->link],
            'template' => '{input}<span class="fa fa-link form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_description[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Description for item', 'value' => $item->description],
            'template' => '{input}<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_weight[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Weight', 'type' => 'number', 'value' => $item->weight],
            'template' => '{input}<span class="fa fa-tachometer form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_price[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Price', 'role' => 'number', 'value' => $item->price],
            'template' => '{input}<span class="fa fa-usd form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

        </div>
      </div>
    </div>
    {/foreach}
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
{literal}
$('body input[role="number"]').number(true, 0);
{/literal}
{/registerJs}
