<?php

//Set header to XML
header('Content-Type: text/xml');

$couponID = htmlspecialchars(trim($_POST['couponID']));

$xml = file_get_contents('http://ilabs.cti.ac.at/iLabServiceBroker/retrievePayload.aspx?couponID='.$couponID);
echo $xml;

?>
