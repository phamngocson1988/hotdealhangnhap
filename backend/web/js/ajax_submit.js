$(document).ready(function(){
  $('.ajax-form-submit').unbind('submit');
  $('.ajax-form-submit').on('submit', function(e) {
    form = $(this);
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      dataType : 'json',
      data: form.serialize(),
      success: function (result, textStatus, jqXHR) {
        if (result.status == false) {
          console.log(result.error);
          errString = '';
          $.each(result.error, function(attr, errs) {
            $.each(result.error, function(i, err) {
              errString += err;
              errString += "\n";
            })
          });
          alert(errString);
          return false;
        } else {
          alert('Success');
        }
      },
    });
    return false;
  });
});