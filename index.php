<?php

// Debugging mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);//*/


//Store GET-parameter as Session variables //TODO: Abfrage, ob parameter ueberhaupt vorhanden...
if (isset($_POST['coupon_id'])){
	$SBcouponID = htmlspecialchars(trim($_POST['coupon_id']));
} else if (isset($_GET['coupon_id'])) {
	$SBcouponID = htmlspecialchars(trim($_GET['coupon_id']));
} else {
	$SBcouponID = 0;
}
if (isset($_POST['passkey'])){
	$SBpasskey = htmlspecialchars(trim($_POST['passkey']));
} else if (isset($_GET['passkey'])) {
	$SBpasskey = htmlspecialchars(trim($_GET['passkey']));
} else {
	$SBpasskey = 0;
}
//TODO: check if couponID and passkey are working with GetLabStatus (and check if lab is online)



/** Generate Experiment Specification **/
function genExpSpec($expSpec){

$header =
'<?xml version="1.0" encoding="utf-8" standalone="no"?>
<experimentSpecification lab="CUAS Blackbody Radiation Lab" specversion="1.0">
<batch>';

$footer =
PHP_EOL.'</batch></experimentSpecification>';

$generalInfo =
PHP_EOL.'<experimentType>'.$expSpec['experimentType'].'</experimentType>
<recordVideo>'.$expSpec['recordVideo'].'</recordVideo>';

//parameters
$parameters = PHP_EOL.'<parameters>';
if($expSpec['experimentType'] == 'd'){
	//distance
	$parameters .= '
	<lightsource>'.$expSpec['parameters']['lightsource'].'</lightsource>
	<sensor>'.$expSpec['parameters']['sensor'].'</sensor>
	<stepsize>'.$expSpec['parameters']['stepsize'].'</stepsize>
	<maxdistance>'.$expSpec['parameters']['maxDistance'].'</maxdistance>';
}else{
	//history
	$parameters .= '
	<lightsource>'.$expSpec['parameters']['lightsource'].'</lightsource>
	<sensor>'.$expSpec['parameters']['sensor'].'</sensor>
	<duration>'.$expSpec['parameters']['duration'].'</duration>';
}
$parameters .= PHP_EOL.'</parameters>';

return $header.$generalInfo.$parameters.$footer;

}//END OF function genExpSpec()



//operation
if( isset($_POST['operation']) && (!empty($_POST['operation'])) ){

	//Set header to XML
	//header('Content-Type: text/xml');

	$operation = htmlspecialchars(trim($_POST['operation']));
	
	require_once(dirname(__FILE__).'/SBproxy.class.php');
	
	try{
		$client = new SBproxy($SBcouponID, $SBpasskey);


		switch($operation){

			case 'Cancel':
			case 'GetExperimentStatus':
			case 'RetrieveResult':
				if ( isset($_POST['experimentID']) ) {
					$parameters = array( 'experimentID' => htmlspecialchars( trim($_POST['experimentID']) ) );
					echo $client->soapCall($operation, $parameters);
				} else {
					//exception
					echo $client->soapCall($operation);
				}
				break;

			case 'GetLabConfiguration':
			case 'GetLabStatus':
				echo $client->soapCall($operation);
				break;

			case 'Submit':
				if ( isset($_POST['expSpec']) ) {
					//$_POST['expSpec'] = array_map('trim', $_POST['expSpec']);
					//$_POST['expSpec'] = array_map('htmlspecialchars', $_POST['expSpec']);

					$parameters = array( 'experimentSpecification' => genExpSpec($_POST['expSpec']) );
					echo $client->soapCall($operation, $parameters);
				} else {
					//exception
					echo $client->soapCall($operation);
				}
				break;//*/

			default:
				echo $client->soapCall($operation);//returns an exception in XML format
				break;
		}

	} catch(Exception $e) {
		return '__'.$e.'__';//TODO: check
	}//*/
}else{
	//display client
	require_once(dirname(__FILE__).'/interface.html.php');
}//*/

?>
