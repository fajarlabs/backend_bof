<?php
require 'vendor/autoload.php';
use Ramsey\Uuid\Uuid;

function randomGen($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

date_default_timezone_set('GMT');
$deliveryTimeStamp = gmdate('d/m/Y h:i:s \G\M\T', time());

$uuid = Uuid::uuid4();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//Get the raw POST data from PHP's input stream.
	//This raw data should contain XML.
	$postData = trim(file_get_contents('php://input'));
	$message_id = implode(randomGen(0,10,7));
	file_put_contents('./files/store_'.$message_id.'_'.date('d_m_Y_h_i_s').'.xml', $postData);

	header("Content-type: text/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8"?>
	<stuResponseMsg 
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:noNamespaceSchemaLocation="http://cody.glpconnect.com/XSD/StuResponse_Rev1_0.xsd"
		deliveryTimeStamp="'.$deliveryTimeStamp.'" 
		messageID="'.$message_id.'"
		correlationID="'.$uuid.'">
			<state>pass</state> 
			<stateMessage>Store OK</stateMessage>
	</stuResponseMsg>';
}
?> 