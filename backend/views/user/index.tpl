{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}
{use class='yii\helpers\ArrayHelper'}

<div class="page-title">
  <div class="title_left">
    <h3>Users</h3>
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
	              <th class="column-title">Username </th>
	              <th class="column-title">Name </th>
	              <th class="column-title">Email </th>
	              <th class="column-title">Role </th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	            <tr class="even pointer">
	              <td class=" ">{$model->getUserName()}</td>
	              <td class=" ">{$model->getName()}</td>
	              <td class=" ">{$model->getEmail()}</td>
	              <td class=" ">
	              {$roles = $app->authManager->getRolesByUser($model->id)}
	              {$names = ArrayHelper::getColumn($roles, 'description')}
	              {implode(', ', $names)}
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