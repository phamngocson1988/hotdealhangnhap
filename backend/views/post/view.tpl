{use class='yii\widgets\ActiveForm' type='block'}

{if $app->session->hasFlash('error')}
<div class="alert alert-danger" role="alert">
  {$app->session->getFlash('error')}
</div>
{/if}

<div class="page-title">
  <div class="title_left">
    <h3>Post Controller <small> View Action </small></h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{$model->getTitle()}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="bs-docs-section">
          {foreach $model->images as $image}
          <div class="col-md-55">
            <div class="image view view-first">
              <img style="width: 100%; display: block;" src="{$image->getUrl()}" alt="image" />
            </div>
          </div>
          {/foreach}
        </div>
      </div>

      <div class="bs-docs-section">
        <h1 id="glyphicons" class="page-header">Content</h1>
        {$model->getContent()}
      </div>

      <div class="bs-docs-section">
        <h1 id="glyphicons" class="page-header">Contact</h1>
        <b>Contact Name:</b> {$model->getContactName()} <br/>
        <b>Contact Number:</b> {$model->getContactPhone()}
      </div>

      <div class="bs-docs-section">
        <h1 id="glyphicons" class="page-header">Category</h1>
        <b>Category:</b> {$model->category->getName()}
      </div>

      <div class="bs-docs-section">
        <h1 id="glyphicons" class="page-header">Author</h1>
        <b>Author:</b> {$model->user->getName()}
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          {if ($model->isVisible())}
          <a class="btn btn-default" href="{url route='post/disapprove' id=$model->getId()}" role="button">Disapprove</a>
          {else}
          <a class="btn btn-success" href="{url route='post/approve' id=$model->getId()}" role="button">Approve</a>
          {/if}
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#report-message">Report</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Reports</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
      
        <!-- start recent activity -->
        <ul class="messages">
          {foreach $model->warnings as $warning}
          <li>
            <img src="../../images/avatar.png" class="avatar" alt="Avatar">
            <div class="message_date">
              <h3 class="date text-error">{date('d', $warning->getCreatedAt())}</h3>
              <p class="month">{date('F', $warning->getCreatedAt())}</p>
            </div>
            <div class="message_wrapper">
              <h4 class="heading">{$warning->createdUser->getName()}</h4>
              <blockquote class="message">{$warning->getContent()}</blockquote>
              <br />
              <p class="url">
                <span class="fs1" aria-hidden="true" data-icon=""></span>
                <a href="{url route='post/delete-warning' id=$model->getId()}" data-original-title="">Delete</a>
              </p>
            </div>
          </li>
          {/foreach}
        </ul>
        <!-- end recent activity -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="report-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Report Content</h4>
      </div>
      {ActiveForm action={url route="post/warning" id=$model->getId()} method='post'}
        <div class="modal-body">
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <input type="text" class="form-control" name="message" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send message</button>
        </div>
      {/ActiveForm}
    </div>
  </div>
</div>