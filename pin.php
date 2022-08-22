<?php

$howmany = 5;

 $length = 3;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$a=0;
while($a < $howmany) {
	$randChar=rand(0,500);
$randomString = $randChar;

$a++;
}
	$range = range(0,($charactersLength - 1));
for ($i = 0; $i < $length; $i++) {
	

		
    $randomString .= $characters[shuffle($range)];
	
}
 echo $randomString; 
 
 
 
 



?>