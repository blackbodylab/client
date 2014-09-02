/**
Example of how to parse a string from a SOAP Fault.
**/
function parseSoapFault(xml) {

	if ( $(xml).find('faultstring') ) {
		//Parse XML
		var faultcode = $(xml).find('faultcode').text();
		var faultstring = $(xml).find('faultstring').text();
		//Parse Faultstring
		if ( faultstring == 'Server was unable to process request. \-\-\-\> The ticket has expired.' ) {
			//msg: Your ticket has expired. Request a new one.
			console.log('Ticket expired.');
		}
	}

}
