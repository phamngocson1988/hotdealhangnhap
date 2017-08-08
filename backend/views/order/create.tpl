{use class='yii\helpers\Html'}
{use class='yii\widgets\ActiveForm' type='block'}
{use class='yii\helpers\ArrayHelper'}
<div class="page-title">
  <div class="title_left">
    <h3>Create New Order</h3>
  </div>
</div>

<div class="clearfix"></div>

{ActiveForm assign='form'}
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
        {$form->field($model, 'customer_email', [
          'options' => ['class' => 'col-md-12 col-sm-12 col-xs-12 form-group'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Email'],
          'template' => '<div class="input-group">{input}<span class="input-group-btn"><button type="button" id="search-customer" class="btn btn-primary">Search!</button></span></div>'
        ])->textInput()}

        {$form->field($model, 'customer_name', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Name'],
          'template' => '{input}<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'customer_phone', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Phone'],
          'template' => '{input}<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'customer_address', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Address'],
          'template' => '{input}<span class="fa fa-location-arrow form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'customer_facebook', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Facebook'],
          'template' => '{input}<span class="fa fa-facebook form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}
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

    <div class="x_panel item">
      <div class="x_title">
        <h2>Item</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li style="float: right"><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="form-group">
          {$form->field($model, 'item_link[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Link'],
            'template' => '{input}<span class="fa fa-link form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_description[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Description for item'],
            'template' => '{input}<span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_weight[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Weight', 'type' => 'number'],
            'template' => '{input}<span class="fa fa-tachometer form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

          {$form->field($model, 'item_price[]', [
            'options' => ['class' => 'col-md-6 col-sm-6 col-xs-12 form-group has-feedback'],
            'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Price', 'role' => 'number'],
            'template' => '{input}<span class="fa fa-usd form-control-feedback left" aria-hidden="true"></span>'
          ])->textInput()}

        </div>
        <button type="button" class="btn btn-link" style="float: right;" action="add-order-item">Add item</button>
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
{literal}
$("body").on('click', '[action="add-order-item"]', function(){
  var _ic = $(this).closest('div.item');
  var _n = _ic.clone();
  _n.find('input').val('');
  _n.insertAfter(_ic);
});
$("body").on('click', 'a.close-link', function(){
  if ($('div.item').length == 1) {
    return;
  }
  $(this).closest('div.item').remove();
});

// Search Customer
$("#search-customer").on('click', function(){
  $.ajax({
    url: '{/literal}{$links.find_customer}{literal}',
    type: "GET",
    dataType: 'json',
    data: {term: $('[name="InsertOrderForm[customer_email]"]').val()},
    success: function (result, textStatus, jqXHR) {
      if (result.status == true) {
        var customer = result.data;
        $("[name='InsertOrderForm[customer_name]']").val(customer.name).prop('disabled', true);
        $("[name='InsertOrderForm[customer_address]']").val(customer.address).prop('disabled', true);
        $("[name='InsertOrderForm[customer_phone]']").val(customer.phone).prop('disabled', true);
        $("[name='InsertOrderForm[customer_facebook]']").val(customer.facebook).prop('disabled', true);
      } else {
        $("[name='InsertOrderForm[customer_name]']").val('').prop('disabled', false);
        $("[name='InsertOrderForm[customer_address]']").val('').prop('disabled', false);
        $("[name='InsertOrderForm[customer_phone]']").val('').prop('disabled', false);
        $("[name='InsertOrderForm[customer_facebook]']").val('').prop('disabled', false);
      }
    },
  });
});

// Enter on email input
$('#insertorderform-customer_email').keydown(function() {
  if ( event.which == 13 ) {
    event.preventDefault();
    $("#search-customer").trigger('click');
  }
});


$('body input[role="number"]').number(true, 0);
{/literal}
{/registerJs}
