<?php

$data = $_POST['data'];
$type = ($_POST['type']=='d')?'distance':'history';

//Header
header('Content-Type: application/csv');
header('Content-Disposition: attachment;Filename=Blackbody_'.$type.'_'.date('Ymd-His').'.csv');

//Content
echo $data;

?>
