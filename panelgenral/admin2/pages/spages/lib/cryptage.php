<?php

function crypter($url){
  $algo = "gost"; 
  $mode = "cfb"; 
  $key_size = mcrypt_module_get_algo_key_size($algo);
  $iv_size = mcrypt_get_iv_size($algo, $mode);
  $iv = "aluteret";
  $cle = "kalonjitony1";
  $cle = substr($cle, 0, $key_size);
  $texte = rawurldecode($url);
  return(rawurlencode(mcrypt_encrypt($algo, $cle, $texte, $mode, $iv)));
 }


function decrypter($url){
  $algo = "gost"; 
  $mode = "cfb";
 
  // calcul des longueurs max de la clé et de l'IV
  $key_size = mcrypt_module_get_algo_key_size($algo);
  $iv_size = mcrypt_get_iv_size($algo, $mode);
  
  $iv = "aluteret";
 
  $cle = "kalonjitony1";
  $cle = substr($cle, 0, $key_size);
  
  $crypte = rawurldecode($url);
  
  return (mcrypt_decrypt($algo, $cle, $crypte, $mode, $iv));
 }
 

?>
