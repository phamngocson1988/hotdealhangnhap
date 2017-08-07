{use class='yii\widgets\ActiveForm' type='block'}

{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}

<div class="page-title">
  <div class="title_left">
    <h3>View Order Detail</small></h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">

      <div class="bs-docs-section">
        <h3 id="glyphicons" class="page-header">Customer</h3>
        <b>Name:</b> {$model->customer->name} <br/>
        <b>Email:</b> {$model->customer->email} <br/>
        <b>Address:</b> {$model->customer->address} <br/>
        <b>Phone:</b> {$model->customer->phone} <br/>
        <b>Facebook:</b> {$model->customer->facebook} <br/>
      </div>

      <div class="bs-docs-section">
        <h3 id="glyphicons" class="page-header">Order</h3>
        <b>Code:</b> {$model->code} <br/>
        <b>Date:</b> {date('d-m-Y', $model->order_date)} <br/>
        <b>Description:</b> {$model->description} <br/>
        <b>Prepay:</b> {number_format ($model->prepay)} <br/>
      </div>

      <div class="bs-docs-section">
        <h3 id="glyphicons" class="page-header">Items</h3>
        <div class="table-responsive">
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr class="headings">
                <th class="column-title">Link </th>
                <th class="column-title">Description </th>
                <th class="column-title">Price </th>
                <th class="column-title">Tracking </th>
                <th class="column-title">Process </th>
              </tr>
            </thead>

            <tbody>
              {foreach $model->items as $item}
              <tr class="even pointer">
                <td class=" ">{$item->link}</td>
                <td class=" ">{$item->description}</td>
                <td class=" ">{number_format($item->price)}</td>
                <td class=" ">{$item->tracking}</td>
                <td class=" ">{$item->getProgressName()}</td>

              </tr>
              {/foreach}
            </tbody>
          </table>
      </div>

      <div class="ln_solid"></div>
      <!-- <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          <a class="btn btn-default" href="#" role="button">Disapprove</a>
        </div>
      </div> -->
    </div>
  </div>
</div>


