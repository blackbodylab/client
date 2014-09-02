/**
Changes text of the Progressbar label.
**/

function updateProgressbar(type, statusText, queueLength) {

	var queueText = (queueLength != '') ? ', Queue Length: ' + queueLength : '';
	$('#lbl_expProgressbar_'+type).text('Status: ' + statusText + queueText);

}
