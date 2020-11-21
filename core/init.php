<?php

//////////////////////////////////////////////////////////////////////////////
///////////////////////////Global initialization file/////////////////////////
//////////////////////////////////////////////////////////////////////////////

/****DataBase Conifguration array****/
session_start();
$GLOBALS['config']= array(
	'mysql' =>array(
     'host' => '127.0.0.1',
     'username' => 'root',
     'password' =>'',
     'db' => 'cart_pricing'
	));



/****spacial library function to include all needed files ****/
spl_autoload_register(function($class){

	$array = explode('\\', getcwd());
    if (in_array('controller', $array)) {
	 	  require_once $class.'_controller.class.php';
        }
     elseif (in_array('view', $array)) {
        	require_once '../../controller/'.$class.'_controller.class.php';
        }else{
           require_once 'controller/'.$class.'_controller.class.php';
        }  

});
