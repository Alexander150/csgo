<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Items: <br>";

$key = '7z79P78iX4byW7n01wG3SSooB4yTLH9';
$items = [
  [
    'classid' => 310778280,
    'instanceid' => 0
  ],
];
// print_r($items);
echo "<br><br>";

// $curl_handle=curl_init();

function callToApi($link) {
  $info = file_get_contents($link);
  $info = json_decode($info, true);
  return $info;  
}
function prettyArrayPrint($array) {
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

foreach ($items as $v) {

  $link = "https://market.csgo.com/api/ItemInfo/{$v['classid']}_{$v['instanceid']}/ru/?key=$key";
  // echo "$link<br>";

  // curl_setopt($curl_handle, CURLOPT_URL,'https://market.csgo.com/api/ItemInfo/$v.classid_$v.instanceid/ru/?key=$key');
  // curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
  // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
  // curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla Firefox');
  // $info = curl_exec($curl_handle);
  
  $answer = callToApi($link);
  // prettyArrayPrint($answer);
  echo "Предмет: {$answer['market_name']}, редкость: {$answer['rarity']}, тип: {$answer['type']}, мин. цена: {$answer['min_price']}";
  echo "<br><br>";

  $link = "https://market.csgo.com/api/ItemHistory/{$v['classid']}_{$v['instanceid']}/?key=$key";
  $answer = callToApi($link);
  echo "Последние 500 покупок: цена от {$answer['min']} до {$answer['max']}, в среднем {$answer['average']}";
  $max = ($answer['number'] > 10) ? 10 : $answer['number'];
  echo "<br>Последние $max продаж:<br>";
  for ($i=0; $i < $max; $i++) {
    echo "<div style=\"display:inline-block;margin:0 5px 0 0;\">{$answer['history'][$i]['l_price']}</div>";
  }
  echo "<br><br>";

  $link = "https://market.csgo.com/api/BestSellOffer/{$v['classid']}_{$v['instanceid']}/?key=$key";
  $answer = callToApi($link);
  echo "Лучшая цена: <b>{$answer['best_offer']}</b>";

  echo "<hr>";
}