{use class='yii\widgets\ActiveForm' type='block'}

{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}

<div class="page-title">
  <div class="title_left">
    <h3>Update Order Item</h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
      <h2>Customer</h2>
      <div class="bs-docs-section">
        <b>Name:</b> {$customer->name} <br/>
        <b>Email:</b> {$customer->email} <br/>
        <b>Address:</b> {$customer->address} <br/>
        <b>Phone:</b> {$customer->phone} <br/>
        <b>Facebook:</b> {$customer->facebook} <br/>
      </div>
    </div>

    <div class="x_panel">
      <h2>Order</h2>
      <div class="bs-docs-section">
        <b>Order Code:</b> {$order->code} <br/>
        <b>Description:</b> {$order->description} <br/>
        <b>Prepay:</b> {number_format($order->prepay)} <br/>
        <b>Order Date:</b> {date('d-m-Y', $order->order_date)} <br/>
      </div>
    </div>

    <div class="x_panel">
      <h2>Item</h2>
      <div class="bs-docs-section">
        <b>Link:</b> {$item->link} <br/>
        <b>Description:</b> {$item->description} <br/>
        <b>Weight:</b> {number_format($item->weight)} <br/>
        <b>Price:</b> {number_format($item->price)} <br/>
        <b>Progress:</b> {$item->getProgressName()} <br/>
        <b>Tracking:</b> {$item->tracking} <br/>
      </div>
    </div>

    {ActiveForm assign='form'}
    {$form->field($model, 'id', ['inputOptions' => ['value' => $item->id]])->hiddenInput()->label(false)}
    <div class="x_panel">
      <div class="form-group">
        {$form->field($model, 'weight', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Weight', 'value' => $item->weight],
          'template' => '{input}<span class="fa fa-tachometer form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}

        {$form->field($model, 'tracking', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 col-xs-12 form-group has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Tracking', 'value' => $item->tracking],
          'template' => '{input}<span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button id="send" type="submit" class="btn btn-success">Update</button>
          <a href="{url route=$links.update_progress id=$item->id progress=$item->getPrevProgress()}" class="btn btn-primary" type="button" action="prev">Prev Step</a>
          <a href="{url route=$links.update_progress id=$item->id progress=$item->getNextProgress()}" class="btn btn-primary" type="button" action="next">Next Step</a>
        </div>
      </div>
    </div>
    {/ActiveForm}
    {include file=$template}
   
  </div>
</div>

{registerJs}
{literal}
{/literal}
{/registerJs}