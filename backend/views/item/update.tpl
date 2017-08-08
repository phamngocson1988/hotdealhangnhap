{use class='yii\widgets\ActiveForm' type='block'}

{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}


<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update Order Item</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <section class="content invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12 invoice-header">
              <h1>
                <i class="fa fa-hashtag"></i> Order item.
                <small class="pull-right">Date: {date('d-m-Y', $order->order_date)}</small>
              </h1>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong>Customer</strong>
                <br/><b>Name:</b> {$customer->name} 
                <br/><b>Email:</b> {$customer->email} 
                <br/><b>Address:</b> {$customer->address} 
                <br/><b>Phone:</b> {$customer->phone} 
                <br/><b>Facebook:</b> {$customer->facebook} 
                <br/><b>Note:</b> {$customer->note}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <address>
                <strong>Order</strong>
                <br/><b>Order Number:</b> {$order->order_number} 
                <br/><b>Stock:</b> {$order->getStockName()} 
                <br/><b>Description:</b> {$order->description} 
                <br/><b>Prepay (VND):</b> {number_format($order->prepay)} 
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <address>
                <strong>Item</strong>
                <br/><b>Link:</b> {$item->link} 
                <br/><b>Description:</b> {$item->description}
                <br/><b>Weight (g):</b> {number_format($item->weight)}
                <br/><b>Price (VND):</b> {number_format($item->price)}
                <br/><b>Progress:</b> {$item->getProgressName()} 
                <br/><b>Tracking:</b> {$item->tracking}
              </address>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

         

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
              <p class="lead">Shipping Methods:</p>
              {if $item->deliverer !== null}
              {if $item->deliverer == 1}
              <img width="100px" height="50px" class="img-responsive" src="../../images/hotdealhangnhap.jpg" alt="Giao Hàng Tại Kho">
              {elseif $item->deliverer == 2}
              <img width="100px" height="50px" class="img-responsive"  src="../../images/viettelpost.jpg" alt="Viettel Post">
              {elseif $item->deliverer == 3}
              <img width="100px" height="50px" class="img-responsive"  src="../../images/giao-hang-tiet-kiem.png" alt="Giao Hàng Tiết Kiệm">
              {/if}
              {if $item->note}
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                {$item->note}
              </p>
              {/if}
              {else}
              <p>Updating...</p>
              {/if}
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
              <p class="lead">Summary</p>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <th style="width:50%">Price:</th>
                      <td>{number_format($item->price)} (VNĐ)</td>
                    </tr>
                    <tr>
                      <th>Weight Fee:</th>
                      <td>{number_format($item->weight_fee)} (VNĐ)</td>
                    </tr>
                    <tr>
                      <th>Prepay:</th>
                      <td>{number_format($order->prepay)} (VNĐ)</td>
                    </tr>
                    <tr>
                      <th>COD:</th>
                      <td>{number_format($item->cod)} (VNĐ)</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </section>
      </div>
    </div>
    <div class="x_panel">
      <div class="x_content">
        {ActiveForm assign='form' options=['class' => 'form-horizontal form-label-left']}
        {$form->field($model, 'id', ['inputOptions' => ['value' => $item->id]])->hiddenInput()->label(false)}
          {if $app->user->can('admin')}
          <div class="form-group">
            {$form->field($model, 'order_number', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Order Number'],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->textInput()}
          </div>
          {/if}

          {if $app->user->can('us_keeper')}
          <div class="form-group">
            {$form->field($model, 'tracking', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Tracking', 'value' => $item->tracking],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->textInput()}
          </div>
          <div class="form-group">
            {$form->field($model, 'order_stock', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12'],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->dropDownList($model->supportStock(), ['prompt' => 'Please Choose Stock...'])}
          </div>
          <div class="form-group">
            {$form->field($model, 'weight', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Weight', 'value' => $item->weight, 'role' => 'number'],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->textInput()->label('Weight (g)') }
          </div>
          {/if}
          
          {if $app->user->can('vn_keeper')}
          <div class="form-group">
            {$form->field($model, 'deliverer', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12'],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->dropDownList($model->supportDeliverer(), ['prompt' => 'Please Choose Deliverer...'])}
          </div>
          <div class="form-group">
            {$form->field($model, 'cod', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Cash On Delivery', 'value' => $item->cod, 'role' => 'number'],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->textInput()}
          </div>

          <div class="form-group">
            {$form->field($model, 'note', [
              'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
              'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Note for deliver', 'value' => $item->note],
              'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>'
            ])->textarea()}
          </div>
          {/if}
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        {/ActiveForm}
      </div>
    </div>

    {include file=$template}
  </div>

  
</div>
{registerJs}
{literal}
$('body input[role="number"]').number(true, 0);
{/literal}
{/registerJs}