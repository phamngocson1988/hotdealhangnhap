{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}

<div class="page-title">
  <div class="title_left">
    <h3>Post Controller <small> Index Action </small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	  <div class="x_panel">
	    <div class="x_title">
	      <h2>Table design <small>Custom design</small></h2>
	      <div class="clearfix"></div>
	    </div>

	    <div class="x_content">

	      <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p>
	      {Pjax}
	      <div class="table-responsive">
	        <table class="table table-striped jambo_table bulk_action">
	          <thead>
	            <tr class="headings">
	              <th class="column-title">Title </th>
	              <th class="column-title">Category </th>
	              <th class="column-title">Author </th>
	              <th class="column-title">Status </th>
	              <th class="column-title">Checked </th>
	              <th class="column-title">Created Date </th>
	              <th class="column-title">Action </th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	            <tr class="even pointer">
	              <td class=" ">{$model->getTitle()}</td>
	              <td class=" ">{$model->category->getName()}</td>
	              <td class=" ">{$model->user->getName()}</td>
	              <td class=" ">
	              	{if !$model->getCheckedBy()}
	              	<span class="label label-default">New</span>
	              	{elseif $model->isVisible()}
									<span class="label label-success">Approved</span>
									{else}
									<span class="label label-warning">Warning</span>
									{/if}
	              </td>
	              <td class=" ">
	              	{if $model->getCheckedBy()}
	              		{$model->checkedByUser->getName()}
	              	{/if}
	              </td>
	              <td class="a-right a-right ">{$model->getCreatedAt(true)}</td>
	              <td class=" last">
	              	<a href='{url route="post/view" id=$model->getId()}' class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                  <a href='{url route="post/view" id=$model->getId()}' class="btn btn-info btn-xs"><i class="fa fa-pencil"></i></a>
                  <a href='{url route="post/delete" id=$model->getId()}' class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
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
$('.x_content').on("click", 'tr a.btn-primary', function(event) { 
	event.preventDefault();
	var _href = $(this).attr('href');
	var _v = $(this).find('.fa-eye').length;
	_v = (_v) ? 0 : 1;
  that = this;
  $.ajax({
    url: _href,
    type: "GET",
    data: {visible: _v},
    dataType: 'json',
    success: function (result, textStatus, jqXHR) {
        if (result.status == false) {
          //alert(result.error);
        } else {
          if (!_v) {
          	$(that).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
          } else {
          	$(that).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
          }
        }
        
    },
  });

});
{/literal}
{/registerJs}