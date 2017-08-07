function UploadImage(opts) {
    // default configuration properties
    this.options = {
        request_url : 'http://investment.com/image/ajax-upload-image', //image/ajax-upload-image
        file_element: '#file', // seletor of the file element
        review_width: '150',
        review_height: '150',
        multiple: false,
    }; 
    // form to push data to server
    this.form = new FormData();
 
    //constructor
    this.init = function (opts) {
        this.options = $.extend(this.options, opts);
        that = this;
	    $(this.options.file_element).on('change', function(){
            element_name = $(this).attr('name');
			that.form.append('name', element_name);
			that.form.append('review_width', that.options.review_width);
			that.form.append('review_height', that.options.review_height);
			$.each(this.files, function( index, value ) {
				var file = value;
				var imagefile = file.type;
				var match= ["image/jpeg","image/png","image/jpg"];
				if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
					return false;
				} else {
					that.form.append(element_name, file);
				}
			});
			
			that.upload();
		});
    };


    this.upload = function() {
  //   	if (Object.keys(this.form).length == 0) {
		// 	return;
		// }
		that = this;
    	$.ajax({
			url: this.options.request_url,
			type: 'POST',
			processData: false, // important
			contentType: false, // important
			dataType : 'json',
			data: this.form,
			success: function (result, textStatus, jqXHR) {
                if (result.status == false) {
                    alert('false');
                    return false;
                } else {
                    that.callback(result);
                }
                 
            },
            complete: function() {
        		that.reset();
            }
		});
    }

    //reset
    this.reset = function() {
        this.form = new FormData();
        $(this.options.file_element).val('');
    }

    this.callback = function(result) {
        console.log('callback');
    }

    this.init(opts);
};