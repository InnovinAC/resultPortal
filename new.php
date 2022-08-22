<?php

 /*  $url = 'https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=USD';
  $data = file_get_contents($url);
  $priceInfo = json_decode($data);

  echo $priceInfo[0]->price_usd; */
  
  

function func() {
$url ='https://api.coingecko.com/api/v3/simple/price?ids=tron&vs_currencies=usd';// path to your JSON file
$data = file_get_contents($url);
  $priceInfo = json_decode($data);
	$obj = new stdClass;
	$obj->usd = $priceInfo->usd;
  RETURN	 $obj->usd;

}

echo func();
?>