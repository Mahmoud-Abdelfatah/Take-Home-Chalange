<?php

/****class for configurations ****/
class Config
{
  ///////// function to get object by path from array/////////////  
 public static function get($path =null)
  {
    if ($path) {
        $config = $GLOBALS['config'];
        $path = explode('/',$path);
         
        foreach ($path as  $bit) {
            if (isset($config[$bit])) {
                $config = $config[$bit];
            }
         } 

         return $config;
    }
     return false;
  }
}
