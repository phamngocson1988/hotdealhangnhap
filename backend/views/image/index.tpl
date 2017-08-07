<div class="page-title">
  <div class="title_left">
    <h3> Media Gallery <small> gallery design</small> </h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Media Gallery <small> gallery design </small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row" id="items">
        	
        	

        </div>

        <div class="row">
        	<div class="col-md-4 col-md-offset-4">
        		<button type="button" class="btn btn-default btn-block" id="load_more">Load More</button>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>

{registerJs}
<!-- inline scripts related to this page -->
{literal}
$(document).ready(function(){
	var paging = new AjaxPaging({
		auto_first_load: true,
	});
	$('#load_more').on('click', function(){
		paging.load();
	});

  // delete
  $('#items').on("click", '.delete', function(event) { 
    event.preventDefault()
    var _i = $(this).closest('.image-item').data('id');
    var _href = $(this).attr('href');
    that = this;
    $.ajax({
      url: _href,
      type: "GET",
      dataType: 'json',
      success: function (result, textStatus, jqXHR) {
          if (result.status == false) {
            alert(result.error);
          } else {
            $(that).closest('.image-item').detach();
          }
          
      },
    });
  });
})
{/literal}
{/registerJs}