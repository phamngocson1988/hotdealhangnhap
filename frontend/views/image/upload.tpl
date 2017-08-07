<input type="file" name="imageFiles" id="file">
{registerJs}
<!-- inline scripts related to this page -->
{literal}
$(document).ready(function (e) {
	var upload = new UploadImage({});		
	$("#submit").click(function(){
		$("#file").trigger('click');
	})
});
{/literal}
{/registerJs}