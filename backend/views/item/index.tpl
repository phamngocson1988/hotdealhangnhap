{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}
{use class='yii\widgets\ActiveForm' type='block'}
{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}

<div class="page-title">
  <div class="title_left">
    <h3>Order Items</h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Search Item</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form class="form-horizontal" method="get">
	        <div class="form-group">
	        	<div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
	            <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Customer Email" name="email" value="{$form->email}">
	            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
	          </div>

	          <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
	            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Tracking" name="tracking" value="{$form->tracking}">
	            <span class="fa fa-hashtag form-control-feedback left" aria-hidden="true"></span>
	          </div>
					</div>
					<div class="form-group">
	          <div class="col-md-6 col-sm-6 col-xs-12">
	            <select class="form-control" name="progress">
	              <option value="">Choose progress</option>
	              {foreach $form->getSupportedProgress() as $pk => $pv}
	              <option value="{$pk}" {if $form->progress == $pk}selected{/if}>{$pv}</option>
	              {/foreach}
	            </select>
	          </div>

	          <div class="col-md-6 col-sm-6 col-xs-12 ">
	            <select class="form-control" name="month">
	              <option value="">Choose month</option>
	              {foreach $form->getMonths() as $mk => $mv}
	              <option value="{$mk}" {if $form->month == $mk}selected{/if}>{$mv}</option>
	              {/foreach}
	            </select>
	          </div>
					</div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <button type="submit" class="btn btn-success" style="float: right;">Search</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	  <div class="x_panel">
	    

	    <div class="x_content">

	      {Pjax}
	      <div class="table-responsive">
	        <table class="table table-striped jambo_table bulk_action">
	          <thead>
	            <tr class="headings">
		            <th class="column-title">Name </th>
		            <th class="column-title">Phone </th>
		            <th class="column-title">Address </th>
		            <th class="column-title">Order Number </th>

	              <th class="column-title">Link </th>
	              <th class="column-title">Description </th>
	              <th class="column-title">Price </th>
	              <th class="column-title">Tracking </th>
	              <th class="column-title">Progress </th>
	              <th class="column-title">Action </th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	          		{$customer = $model->customer}
	          		{$order = $model->order}
	            <tr class="even pointer">
		            <td class=" ">{$customer->name}</td>
		            <td class=" ">{$customer->phone}</td>
		            <td class=" ">{$customer->address}</td>
		            <td class=" ">{$order->order_number}</td>
	              <td class=" ">{$model->link}</td>
	              <td class=" ">{$model->description}</td>
	              <td class=" ">{number_format($model->price)}</td>
	              <td class=" ">{$model->tracking}</td>
	              <td class=" ">{$model->getProgressName()}</td>
	              <td class=" last">
	              	<a href='{url route="item/update" id=$model->id}' class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
	              	{if !$model->isComplete()}
	              	<a href='{url route=$links.update_progress id=$model->id progress=$model->getNextProgress()}' class="btn btn-primary btn-xs" alt="Next" action="update-progress"><i class="fa fa-share"></i></a>
	              	{/if}
	              </td>
	            </tr>
	        		{/foreach}
	          </tbody>
	        </table>
	      </div>

	      <nav aria-label="Page navigation" class="pull-right">
		  		{LinkPager::widget(['pagination' => $pages])}
				</nav>
				{/Pjax}
	    </div>
	  </div>
	</div>
</div>

{registerJs}
{literal}
{/literal}
{/registerJs}