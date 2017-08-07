<textarea name="content" id="content" cols="30" rows="10"></textarea>   
<input type="file" name="imageFiles" id="file">
{registerJs}
<!-- inline scripts related to this page -->
{literal}
$(document).ready(function (e) {
	var upload = new UploadImage({});		
	// CKEDITOR.editorConfig = function( config ) {
	// 	config.filebrowserImageBrowseUrl = 'http://admin.delivery.com/file';
	// 	config.filebrowserImageUploadUrl = 'http://admin.delivery.com/editor/upload-image';
	// };
	CKEDITOR.replace('content'); 
});
{/literal}
{/registerJs}