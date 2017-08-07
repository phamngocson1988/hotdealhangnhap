{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}

{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}

<div class="page-title">
  <div class="title_left">
    <h3>Orders</h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Search Order</small></h2>
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
	              <th class="column-title">Customer </th>
	              <th class="column-title">Created Date </th>
	              <th class="column-title">Description </th>
	              <th class="column-title">Prepay </th>
	              <th class="column-title">Action </th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	            <tr class="even pointer">
	              <td class=" ">{$model->customer->name}</td>
	              <td class=" ">{date('d-m-Y', $model->order_date)}</td>
	              <td class=" ">{$model->description}</td>
	              <td class=" ">
	              	{number_format ($model->prepay)}
	              </td>
	              <td class=" last">
	              	<a href='{url route="order/view" id=$model->id}' class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
	              	<a href='{url route="order/update" id=$model->id}' class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
	              	<a href='{url route="order/delete" id=$model->id}' class="btn btn-primary btn-xs"><i class="fa fa-trash-o"></i></a> 
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