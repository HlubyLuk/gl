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
        "$host:$port", $user, $password
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

$parsedFoods = [];
$days = array("po", "út", "st", "čt", "pa");

for ($index = 0; $index < $results->length; $index++) {
    $item0 = $results->item($index);
    $foods = $item0->childNodes;
    $day = new Day();
    $day->day = $days[$index];
    for ($index1 = 0; $index1 < $foods->length; $index1++) {
        $counter = 0;
        $food = new Food();
        $hnuj = $foods->item($index1)->childNodes;
        if ($hnuj instanceof DOMNodeList) {
            foreach ($hnuj as $foo) {
                if ($foo instanceof DOMElement) {
                    $value = preg_replace("/ {2,}/", " ", $foo->nodeValue);
                    $value = preg_replace("/\n/", "", $value);
                    if ($counter % 2 == 0) {
                        $food->name = $value;
                    } else {
                        $food->price = $value;
                        $day->foods[] = $food;
                    }

                    $counter++;
                }
            }
        }
    }
    $parsedFoods[] = $day;
}
echo json_encode($parsedFoods);
