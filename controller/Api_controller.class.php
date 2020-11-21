<?php

require_once 'Cart_controller.class.php';
/**
 * 
 Api Class to handle Cart data
 */
class Api extends Cart
{
	function send_to_cart($user_id,$product_id,$quantity)
	{
		$this->add_to_cart($user_id,$product_id,$quantity);
	}
}

//// required headers to recive json data //////
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

/////////////// geting data sent to api //////////////
$data = json_decode(file_get_contents("php://input"));

if ($data) {
	require_once '../core/init.php'; //////// get includes///////
	$currancy = new Cart();  
	$api = new Api(); 
////////// looping throw json data ///////////////////
foreach ($data as $key => $value) {
	   ///////////// is data are products send it to cart//////////////////////
	if (null!=($value->user_id && null!=($value->product_id) && null!=($value->quantity))) {
		$api->send_to_cart($value->user_id,$value->product_id,$value->quantity);
	}
	///////////////// if data is currancy get new currancy////////////////
	if(null!=isset($value->currancy))
     {
     	$currancy->change_currency($value->currancy);
     }
    ////////////// if no currancy selected by user defult currancy will be US Dolar //////
     else{
     	$currancy->change_currency(3);
     }

}

}


