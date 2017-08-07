<div class="col-md-55 image-item" data-id="{$model->getId()}">
  <div class="thumbnail">
    <div class="image view view-first">
      <img style="width: 100%; display: block;" src="{$model->getUrl('150x150')}" alt="image" />
      <div class="mask">
        <p>{$model->getName()}</p>
        <div class="tools tools-bottom">
          <a href="{$model->getUrl()}" target="_blank"><i class="fa fa-link"></i></a>
          <a href="{url route='image/ajax-delete' id=$model->getId()}" class="delete"><i class="fa fa-times"></i></a>
        </div>
      </div>
    </div>
    <div class="caption">
      <p>Size: {$model->getSize(true)} KB</p>
      <p>Type: {$model->getExtension()}</p>
    </div>
  </div>
</div>