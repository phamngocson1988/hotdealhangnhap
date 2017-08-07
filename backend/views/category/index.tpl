<div class="page-title">
  <div class="title_left">
    <h3>Category Controller <small> Index Action </small></h3>
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
	      <div class="table-responsive">
	        <table class="table table-striped jambo_table bulk_action">
	          <thead>
	            <tr class="headings">
	              <th class="column-title">Name </th>
	              <th class="column-title">Slug </th>
	              <th class="column-title no-link last"><span class="nobr">Action</span></th>
	            </tr>
	          </thead>

	          <tbody>
	          	{foreach $models as $model}
	            <tr class="even pointer">
	              <td class=" ">{$model->getName()}</td>
	              <td class=" ">{$model->getSlug()}</td>
	              <td class=" last">
	              	<a href='{url route="category/edit" id=$model->getId()}' class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>

	              	<a href='{url route="category/change-visible" id=$model->getId()}' class="btn btn-primary btn-xs" action="visible-status">
	              		{if $model->isVisible()}
	              		<i class="fa fa-eye"></i>
	              		{else}
	              		<i class="fa fa-eye-slash"></i>
	              		{/if}
	              	</a>
	              </td>
	            </tr>
	          	{/foreach}
	          </tbody>
	        </table>
	      </div>
	    </div>
	  </div>
	</div>
</div>

{registerJs}
{literal}
$('.x_content').on("click", 'tr a[action="visible-status"]', function(event) {
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