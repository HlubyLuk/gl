<?php
class Day {
	public $day;
	public $foods = [];
}

class Food {
	public $name;
	public $price;
}

header('Content-Type: text/html; charset=utf-8');

$user = 'root';
$password = 'root';
$db = 'go-lunch-db';
$host = 'localhost';
$port = 8889;
$table = 'table_foods';
$endPoint = 'http://www.tradiceandel.cz/cz/denni-nabidka/';
$link = mysql_connect(
   "$host:$port",
   $user,
   $password
);

$curl_init = curl_init($endPoint);
curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, TRUE);
$curl_exec = curl_exec($curl_init);
curl_close($curl_init);

$dom = new DOMDocument;
$dom->loadHTML($curl_exec);

$classname = 'separator-section';
$xpath = new DOMXPath($dom);
$results = $xpath->query("//*[@class='" . $classname . "']");

for ($index = 0; $index < 1; $index++) {
    $item0 = $results->item($index);
    $foods = $item0->childNodes;
    for ($index1 = 0; $index1 < $foods->length; $index1++) {
        $hnuj = $foods->item($index1)->childNodes;
        foreach ($hnuj as $bubu) {
            var_dump($bubu);
        }
    }
}
