{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}

<div class="page-title">
  <div class="title_left">
    <h3>Customers</h3>
  </div>
</div>

<div class="clearfix"></div>
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
	              <th class="column-title">Email </th>
	              <th class="column-title">Address </th>
	              <th class="column-title">Phone </th>
	              <th class="column-title">Facebook </th>
	              <th class="column-title">Note </th>
	              <th class="column-title">Actions </th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	            <tr class="even pointer">
	              <td class=" ">{$model->name}</td>
	              <td class=" ">{$model->email}</td>
	              <td class=" ">{$model->address}</td>
	              <td class=" ">{$model->phone}</td>
	              <td class=" ">{$model->facebook}</td>
	              <td class=" ">{$model->note}</td>
				  			<td class=" last">
	              	<a href='{url route="customer/update" id=$model->id}' class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
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