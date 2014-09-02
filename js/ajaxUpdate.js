/**
After the Ajax-Call of sb_Submit() is done, the setInterval method has to start with ajaxUpdate as function.
**/
function ajaxUpdate(expContainer, expHelper, client, myChart) {

	//TODO: If ajaxErrorCounter exceeds 10...

	if ( (!expHelper.ajaxExecRequest) && (expHelper.curExpIndex != -1) ) {

		if ( expContainer[expHelper.curExpIndex].state == 'GetExperimentStatus' ) {
			sb_GetExperimentStatus(expContainer, expHelper, client, myChart);
		}/* else if ( expContainer[expHelper.curExpIndex].state == 'RetrieveResult' ) {
			sb_RetrieveResult(expContainer, expHelper, client, myChart);
		}*/

	}

}
