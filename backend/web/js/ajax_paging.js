function AjaxPaging(opts) {
    // default configuration properties
    this.options = {
        request_url : '',
        container : '#items',
        append_type: 'append', //replace
        // event_type: 'click',
        auto_first_load: false,
        is_loading: false,
        // callback: callback,

        // Controls
        // load_more_control: '',
        // load_prev_control: '',
        load_more_text: 'More',
        load_prev_text: 'Prev',
        
        // Condition
        query_time: null,
        total: null,
        offset: 0,
        limit: 10,
        condition: null,

    }; 

    //constructor
    this.init = function (opts) {
        this.options = $.extend(this.options, opts);
        if (this.options.auto_first_load === true) {
            this.load();
        }
    };

    //callback
    this.callback = function(result) {
        console.log('callback: over-write me');
    };

    //loading
    this.loading = function() {
        console.log('loading: over-write me');
    }

    //stop_loading
    this.stop_loading = function() {
        console.log('stop_loading: over-write me');
    }

    //error
    this.error = function(result) {
        console.log(result);
        console.log('error: over-write me');
    }

    //no data
    this.no_data = function() {
        console.log('no_data: over-write me');
    }

    //success
    this.success = function(result) {
        
        //Update Total
        if (typeof result.total != 'undefined') {
            this.options.total = result.total;
        }
        
        if (this.options.total === 0) {
            this.no_data();
        }

        //Update offset
        this.options.offset += this.options.limit;
        if (this.options.total != null) {
            this.options.offset = Math.min(this.options.offset, this.options.total);
        }
        
        //Add html to view
        if (this.options.append_type == 'append') {
            $(result.items).appendTo($(this.options.container));
        } else {
            $(this.options.container).html(result.items);
        }

        //Stop loading
        this.stop_loading();

        console.log('success: over-write me');
    }

    //stop_search
    this.stop_search = function() {
        console.log('stop_search: over-write me');
    }

    //load more
    this.load = function () {
        if (this.options.is_loading === true) {
            return;
        }
        
        this.options.is_loading = true;
        if (this.options.total != null && this.options.total == this.options.offset) {
            this.stop_search();
            return false;
        }
        var options = this.options;

        request_data = {
            offset: options.offset,
            limit: options.limit,
        }

        if (options.query_time != null) {
            request_data = $.extend(request_data, {'query_time': options.query_time});
        }

        if (options.condition != null) {
            request_data = $.extend(request_data, options.condition);
        }

        var that = this;
        
        $.ajax({
            url: options.request_url,
            type: "GET",
            data: request_data,
            dataType: 'json',
            beforeSend: that.loading,
            success: function (result, textStatus, jqXHR) {
                if (result.status == false) {
                    that.error(result);
                    return false;
                } else {
                    that.success(result);
                    that.callback(result);
                }
                
            },
            complete: function() {
                that.options.is_loading = false;
            }
        });
    }

    this.init(opts);
}