<textarea name="content" id="content" cols="30" rows="10"></textarea>   
<input type="file" name="imageFiles" id="file">
{registerJs}
<!-- inline scripts related to this page -->
{literal}
$(document).ready(function (e) {
	var upload = new UploadImage({});
	editor = CKEDITOR.replace('content');
	

});
{/literal}
{/registerJs}