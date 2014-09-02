<?php


class SBproxy{


/* Configuration Parameters */
const LS_ID = '';
const WSDL  = 'http://ilabs.cti.ac.at/iLabServiceBroker/iLabServiceBroker.asmx?WSDL';


/* Variables */
private $client = NULL;


/* Constructor */
function __construct($SBcouponID, $SBpasskey){

	//Test if WSDL exists
	$wsdlContent = file_get_contents(self::WSDL);
	//echo '$wsdlContent:'.$wsdlContent.'__END!';

	//TEST: undeklarierte variable ausgeben
	//echo $acacacac;
	
	if(empty($wsdlContent)){
		throw new Exception($this->genXMLresp('exception','Server is not responding.'));
	}else{
		$checkWSDL = simplexml_load_string($wsdlContent);
		if($checkWSDL === false){
			throw new Exception($this->genXMLresp('exception','Unable to load WSDL-file correctly.'));
		}else{
			//Create new client
			$this->client = new SoapClient(self::WSDL, array('exceptions' => 0, 'trace' => 1, 'soap_version' => SOAP_1_2));
			//Set SOAP-header
			$hNamespace = 'http://ilab.mit.edu';
			$hContent = array('couponID' => $SBcouponID,
							'couponPassKey' => $SBpasskey);
			$header = new SOAPHeader($hNamespace, 'sbAuthHeader', $hContent);
			$this->client->__setSoapHeaders($header);
		}
	}
}//END OF function __construct()


/* Methods */

/** Generate responses in XML-format **/
private function genXMLresp($type,$msg,$operation=NULL){
//XML declaration
$resp = '<?xml version="1.0" encoding="utf-8"?>';
//open root element
if(is_null($operation)){
	$resp .= '<SBresponse type="'.$type.'">';
}else{
	$resp .= '<SBresponse type="'.$type.'" operation="'.$operation.'">';
}
//append all warnings and notices from custom error-handler
//TODO:error_handler muss in eigene Klasse
//if(!isset($_SESSION['error_cnt'])){
	$resp .= '<errors />';
//}else{
//	$resp .= '<errors cnt="'.$_SESSION['error_cnt'].'">'.$_SESSION['error_str'].'</errors>';
//	unset($_SESSION['error_cnt']);
//	unset($_SESSION['error_str']);
//}
//append actual message
if($type == 'exception'){
	$resp .= '<exception>'.$msg.'</exception>';
}else{
	$resp .= $msg;
}
//close root element
$resp .= '</SBresponse>';
//return
return $resp;
}//END of private function genXMLresp()



/** Generic function for all needed SOAP calls **/
public function soapCall($operation, $parameters = NULL){
//set client parameter depending on $operation
switch($operation){
	case 'Cancel':
	case 'GetExperimentStatus':
	case 'RetrieveResult':
		if($parameters !== NULL){
			$params = array('experimentID' => $parameters['experimentID']);
		} else {
			return $this->genXMLresp('exception','Parameters missing.');
		}
		break;
	case 'GetLabConfiguration':
	case 'GetLabStatus':
		$params = array('labServerID' => self::LS_ID);
		break;
	case 'Submit':
		if($parameters !== NULL){
			$params = array(
				'labServerID' => self::LS_ID,
				'experimentSpecification' => $parameters['experimentSpecification'],
				'priorityHint' => 0,
				'emailNotification' => false);
		} else {
			return $this->genXMLresp('exception','Parameters missing.');
		}
		break;
	default:
		return $this->genXMLresp('exception','SOAP operation unknown.');
		break;
}
//make a SOAP call
//TODO: try out what happens, if server not responding (make local WSDL file and change name)
$SOAPresp = $this->client->__soapCall($operation, array('parameters' => $params));

//check for soap:Fault
if (is_soap_fault($SOAPresp)) {
	$resp_type = 'soapFault';
	//TODO: $result durch $SOAPresp ersetzen. Im Moment dient es zum Test des Error-Handlers...
	$msg = '<soapFault><faultcode>'.$SOAPresp->faultcode.'</faultcode><faultstring>'.$SOAPresp->faultstring.'</faultstring></soapFault>';
	
	//DEBUG
	$msg .= PHP_EOL . PHP_EOL .'<SubmitSpec>'. PHP_EOL . htmlentities(str_replace('><','>'.PHP_EOL.'<',$this->genSubmitSpec($settings))) . PHP_EOL . '</SubmitSpec>'.PHP_EOL . PHP_EOL;
	$xLastRequest = $this->client->__getLastRequest();
	//$sxe = new SimpleXMLElement($xLastRequest);
	//$child = $sxe->children('Envelope',TRUE)->children();
	//echo '<pre>'.$xLastRequest.'</pre>';
	$msg .= PHP_EOL . PHP_EOL . '<xLastRequest>'.htmlentities(str_replace('><','>'.PHP_EOL.'<',$xLastRequest)).'</xLastRequest>';
	//$msg .= '<lastRequest>'.$sxe.'</lastRequest>';
	//DEBUG END

} else {//success

	$resp_type = 'success';//TODO: Current types exception,soapFault und success. Maybe use 'soapEnvelope' instead of 'success'...
	//strip response out of soap:Body
	$sxe = new SimpleXMLElement($this->client->__getLastResponse());
	$child = $sxe->children('soap',TRUE)->children();
	
	//SOAP-Body as response
	$msg = $child->asXML();

}

//create return message
return $this->genXMLresp($resp_type,$msg,$operation);

}//END OF public function soapCall()


}//END OF class SOAP
?>
