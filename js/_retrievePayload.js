/**
The function retrievePayload is used to get the user name of the client user in the iLab Service Broker.

TODO:
- At the moment this function is just used for testing. The retrieved userName is nowhere saved.
- Maybe change function name to getUsername()

URL of iLab Service Broker Extension:
http://ilabs.cti.ac.at/iLabServiceBroker/retrievePayload.aspx?couponID=2999
**/
function retrievePayload() {

	/* Get Payload and parse userName */

	var userName;

	$.ajax({
		type:		'POST',
		url:		'retrievePayload.php',
		data:		{
						couponID: $.getUrlVars()['coupon_id']
					},//can lead to errors, if couponID is empty; needs improvement
		dataType: 'xml'
	})
	.done(function(xml) {
		var userName = $(xml).find('userName').text();
		console.log(userName);
	})
	.fail(function(xml) {
		//TODO: msg: 'Request failed. Try again!' + switch layers back
		console.log('retrievePayload: ajax.fail');
	});

}
