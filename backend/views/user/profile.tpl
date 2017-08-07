{use class='yii\helpers\Html'}
{use class='yii\widgets\ActiveForm' type='block'}
{use class='yii\widgets\LinkPager'}
{use class='yii\widgets\Pjax' type='block'}
<div class="page-title">
  <div class="title_left">
    <h3>User Profile</h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>User Name</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
          <div class="profile_img">
            <div id="crop-avatar">
              <!-- Current avatar -->
              <img class="img-responsive avatar-view" id="avatar" global="avatar_{$user->getId()}" src="{$user->getAvatarUrl('150x150')}" alt="Avatar" title="Change the avatar">
            </div>
          </div>
          <h3>{$user->getName()}</h3>

          <a class="btn btn-success" action="change-avatar"><i class="fa fa-edit m-right-xs"></i>Change Avatar</a>
          <input type="file" name="change-avatar" id="change-avatar" style="display: none">

          <br />

        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
              <li role="presentation" class=""><a href="#basic_profile" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
              </li>
              <li role="presentation" class=""><a href="#change_password" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Change Password</a>
              </li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

              </div>
              <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
              </div>
              <div role="tabpanel" class="tab-pane fade" id="basic_profile" aria-labelledby="profile-tab">
                {ActiveForm assign='formProfile' options=['class' => 'form-horizontal form-label-left ajax-form-submit'] action=$links.update_profile}
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">User Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="username" disabled="disabled" required="required" class="form-control col-md-7 col-xs-12" value="{$user->getUserName()}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" disabled="disabled" id="last-name" name="email" required="required" class="form-control col-md-7 col-xs-12" value="{$user->getEmail()}">
                    </div>
                  </div>
                  {$formProfile->field($profile, 'name', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label} <span class="required">*</span><div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])}

                  {$formProfile->field($profile, 'phone', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label} <span class="required">*</span><div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])}

                  {$formProfile->field($profile, 'address', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])}

                  {$formProfile->field($profile, 'year_of_birth', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])}
                  
                  {$formProfile->field($profile, 'gender', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])->dropDownList([0 => 'Female', 1 => 'Male'])}

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button class="btn btn-primary" type="reset">Reset</button>
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                {/ActiveForm}
              </div>

              <div role="tabpanel" class="tab-pane fade" id="change_password" aria-labelledby="profile-tab">
                {ActiveForm assign='formPassword' options=['class' => 'form-horizontal form-label-left ajax-form-submit'] action=$links.change_password}
                  {$formPassword->field($password, 'old_password', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])->passwordInput()}

                  {$formPassword->field($password, 'new_password', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])->passwordInput()}

                  {$formPassword->field($password, 're_password', [
                    'labelOptions' => [
                      'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                    ],
                    'template' => '{label}<div class="col-md-6 col-sm-6 col-xs-12">{input}</div>{error}{hint}'
                  ])->passwordInput()}

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button class="btn btn-primary" type="reset">Reset</button>
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                {/ActiveForm}
              </div>
            </div>
          </div>
        </div>

        
      </div>
    </div>
  </div>
</div>

{registerJs}
<!-- inline scripts related to this page -->
{literal}

// Change Avatar
var upload = new UploadImage({
  request_url: '{/literal}{$links.upload_image}{literal}',
  file_element: '#change-avatar'
});   
upload.callback = function(result) {
  $.each(result.images, function( index, img ) {
    $.ajax({
      url: '{/literal}{$links.change_avatar}{literal}',
      type: 'POST',
      dataType : 'json',
      data: {image_id: index},
      success: function (result, textStatus, jqXHR) {
        if (result.status == false) {
          console.log(result.error);
          return false;
        } else {
          $('[global="avatar_{/literal}{$user->getId()}{literal}"]').attr('src', img.thumb);
        }
      },
    });
  });
}
$("a[action='change-avatar']").click(function(){
  $(upload.options.file_element).trigger('click');
});


{/literal}
{/registerJs}