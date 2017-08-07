{use class='yii\widgets\ActiveForm' type='block'}
<div class="page-title">
  <div class="title_left">
    <h3>Form Upload </h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Dropzone multiple file uploader</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p>Drag multiple files to the box below for multi upload or click to select files. This is for demonstration purposes only, the files are not uploaded to any server.</p>

        {ActiveForm assign='form' action={url route="image/ajax-upload"} options=['class' => 'form-horizontal dropzone']}
        <input type="hidden" name="name" value="file"/>
        {/ActiveForm}
        <br />
        <br />
        <br />
        <br />
      </div>
    </div>
  </div>
</div>

{registerJs}
{literal}
{/literal}
{/registerJs}