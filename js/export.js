/**
Contains all export-related functions.
**/
function export2csv(expContainer, myChart, id) {

	var index = [];
	var descriptor = 'x';

	switch(id){
		case 'btn_exportAll_d':
			index = exportAll(expContainer, 'd');
			descriptor = 'distance [mm]';
			break;
		case 'btn_exportAll_h':
			index = exportAll(expContainer, 'h');
			descriptor = 'time [s]';
			break;
		case 'btn_exportGraph_d':
			index = exportGraph(myChart['d']);
			descriptor = 'distance [mm]';
			break;
		case 'btn_exportGraph_h':
			index = exportGraph(myChart['h']);
			descriptor = 'time [s]';
			break;
		default:
			//do nothing
			break;
	}
	console.log(index);
	if (index.length > 0) {

		
		var xAxis = [];
		//Add elements to xAxis
		for (var i = 0; i < index.length; i++) {
			for (var j = 0; j < expContainer[index[i]].data.xAxis.length; j++) {
				//Search if element already exists inside xAxis
				var idx = xAxis.indexOf( expContainer[index[i]].data.xAxis[j] );
				//If idx == -1, the element doesn't exist and will be appended
				if (idx == -1) {
					xAxis.push( expContainer[index[i]].data.xAxis[j] );
				}
			}
		}

		//Sort elements of xAxis
		xAxis.sort(function(a,b){
			return (a > b) ? 1 : -1;
		});
		console.log(xAxis);

		//Init an Array for the values of all experiments
		var valArray = new Array();
		//Append values of every experiment
		for(var i = 0; i < index.length; i++){
			//Init array with 0
			var value = new Array();
			
			
			//Go through every value of the currently selected experiment
			for(var j = 0; j < expContainer[index[i]].data.xAxis.length; j++){
				//Search for element position in xAxis
				var idx = xAxis.indexOf( expContainer[index[i]].data.xAxis[j] );
				//Set value of experiment on the index-position, which has the equal value on x-Axis variable
				value[idx] = expContainer[index[i]].data.value[j];
			}

			console.log(value);

			//Add descriptor to value row
			value.unshift('ID:' + expContainer[index[i]].id + '(' + expContainer[index[i]].set.lightsource +
				',' + expContainer[index[i]].set.sensor + ')');
			//Push values to valArray;
			valArray.push(value);
		}
		console.log(valArray);
		
		//Add xAxis descriptor (must be done after creation of valArray to keep index of array intact)
		xAxis.unshift(descriptor);
		
		var exportArray = '';
		//Push data
		var exportArray = new Array(xAxis);
		for(var i = 0; i < valArray.length; i++){
			exportArray.push(valArray[i]);
		}
		console.log(exportArray);
		//------------
		var exportStr = '';
		for(var i = 0; i < exportArray.length; i++){
			for(var j = 0; j < exportArray[0].length; j++){
				exportStr += exportArray[i][j] + ';';
			}
			exportStr += '\r\n'; //Linebreak
		}
		console.log(exportStr);
		
		
		//In general some indices of the array are undefined
		exportStr = exportStr.replace(/undefined/g,''); // /g stands for global, i.e. all occurrences of undefined are replaced

		console.log(exportStr);
		//Download
		$.download('export2csv.php','data='+exportStr+'&type='+expContainer[index[0]].type);

	} else {
		console.log('index is []');
		//TODO:needs warning message.
	}

}

function exportAll(expContainer, type) {
	var index = [];
	var j = 0;
	for (var i = 0; i < expContainer.length; i++) {
		if (expContainer[i].type == type && expContainer[i].success) {
			index[j] = i;
			j += 1;
		}
	}
	return index;
}

function exportGraph(chart) {
	var index = [];
	for (var i = 0; i < chart.map.length; i++) {
		index[i] = chart.map[i].expIndex;
	}
	return index || [];
}
