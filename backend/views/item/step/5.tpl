<div class="x_panel">
  <div class="x_content">
 		<h2>Progress</h2>
    <!-- Tabs -->
    <div id="item_progress" class="form_wizard wizard_horizontal">
      <ul class="wizard_steps">
        <li>
          <a href="javascript:void(0)" class="done" isdone="1">
            <span class="step_no">1</span>
            <span class="step_descr">
              <small>Unorder</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="done" isdone="1">
            <span class="step_no">2</span>
            <span class="step_descr">
              <small>Ordered</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="done" isdone="1">
            <span class="step_no">3</span>
            <span class="step_descr">
              <small>US Stock</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="done" isdone="1">
            <span class="step_no">4</span>
            <span class="step_descr">
              <small>Transfer</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="done" isdone="1">
            <span class="step_no">5</span>
            <span class="step_descr">
              <small>VN Stock</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="disabled" isdone="0">
            <span class="step_no">6</span>
            <span class="step_descr">
              <small>Shipping</small>
            </span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="disabled" isdone="0">
            <span class="step_no">7</span>
            <span class="step_descr">
              <small>Complete</small>
            </span>
          </a>
        </li>
      </ul>

      {if $app->user->can('vn_keeper')}
      {ActiveForm assign='form' options=['class' => 'form-horizontal']}
      {$form->field($model, 'id', ['inputOptions' => ['value' => $item->id]])->hiddenInput()->label(false)}
      <div class="step-data" style="height: 100px">

        <div class="form-group">
        {$form->field($model, 'deliverer', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 col-xs-12']
        ])->dropDownList($model->supportDeliverer(), ['prompt' => 'Please Choose Deliverer...'] )->label(false)}
        </div>

        <div class="form-group">
        {$form->field($model, 'cod', [
          'options' => ['class' => 'col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 col-xs-12 has-feedback'],
          'inputOptions' => ['class' => 'form-control has-feedback-left', 'placeholder' => 'Cash On Delivery', 'type' => 'number', 'value' => $item->cod],
          'template' => '{input}<span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>'
        ])->textInput()}
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button id="send" type="submit" class="btn btn-success">Update</button>
          <a href="{url route=$links.update_progress id=$item->id progress=$item->getPrevProgress()}" class="btn btn-primary" type="button" action="prev">Prev Step</a>
          <a href="{url route=$links.update_progress id=$item->id progress=$item->getNextProgress()}" class="btn btn-primary" type="button" action="next">Next Step</a>
        </div>
      </div>
      {/ActiveForm}
      {/if}
    </div>

    <!-- End SmartWizard Content -->
  </div>
</div>

{registerJs}
{literal}
$('a[action="next"]').on('click', function(e){
  if (confirm("Are you sure?")) {
    var $form = $(this).closest('form');
    data = $form.data("yiiActiveForm");
    $.each(data.attributes, function() {
      this.status = 3;
    });
    $form.yiiActiveForm("validate");

    var _e = $("form").find(".has-error").length;
    if (_e > 0) {
      return false;
    }
    return true;
  }
});
{/literal}
{/registerJs}