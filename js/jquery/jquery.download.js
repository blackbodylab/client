﻿/**
The following plugin allows you to make a request that returns a file in a similar syntax to jQuery's native Ajax functions.
Source:
http://stackoverflow.com/questions/13874063/php-ajax-jquery-file-download-issue
**/

$.extend({
	download: function(url, data, method){
		//url and data options required
		if (url && data) {
			//data can be string of parameters or array/object
			data = typeof data == 'string' ? data : $.param(data);
			//split params into form inputs
			var inputs = '';
			$.each(data.split('&'), function(){
				var pair = this.split('=');
				inputs += '<input type="hidden" name="' + pair[0] + '" value="' + pair[1] + '" />';
			});
			//send request
			$('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
				.appendTo('body').submit().remove();
		}
	}
});
