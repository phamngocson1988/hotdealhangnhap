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
	<div class="col-md-12 col-sm-12 col-xs-12">
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

    {include file=$template}
   
  </div>
</div>

{registerJs}
{literal}
{/literal}
{/registerJs}