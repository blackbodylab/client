/**
If data from a new experiment is retrieved, the experiment has to be added to select menus.
**/

function updateSelectmenus(expContainer, type) {

	//Get elements
	var $selectExp = $('#sel_exp_'+type);
	var $selectVid = $('#sel_vid_'+type);

	//Clear
	$selectExp[0].innerHTML = '';
	$selectVid[0].innerHTML = '';

	//Append
	for (var i = 0; i < expContainer.length; i++) {
		if (expContainer[i].type == type && expContainer[i].success) {
			var optVal = i;
			if (expContainer[i].type == 'd') {
				var optTxt = 'Exp.' + expContainer[i].id + ' (' + expContainer[i].set.lightsource + ', Sens:'
								+ expContainer[i].set.sensor + ', Dist:' + expContainer[i].set.maxDistance
								+ 'mm, Step:' + expContainer[i].set.stepsize + 'mm)';
			} else {//history
				var optTxt = 'Exp.' + expContainer[i].id + ' (' + expContainer[i].set.lightsource + ', Sens:'
								+ expContainer[i].set.sensor + ', Dur:' + expContainer[i].set.duration + 's)';
			}
			$selectExp.append('<option value="' + optVal + '">' + optTxt + '</option>');

			if (expContainer[i].recVideo === true && expContainer[i].recVideoSuccess === true) {
				$selectVid.append('<option value="' + optVal + '">' + optTxt + '</option>');
			}
		}
	}

	//How to: Refresh (not allowed here)
	//$selectExp.multiselect('refresh');
	//$selectVid.multiselect('refresh');

}
