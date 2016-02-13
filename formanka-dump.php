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
$endPoint = 'http://www.originalformanka.cz/1-denni-menu/';
$link = mysql_connect(
   "$host:$port",
   $user,
   $password
);

$doc = file_get_contents($endPoint);
$dom = new DOMDocument;
$dom->loadHTML($doc);
$tables = $dom->getElementsByTagName('table');
$menu = $tables[1];
$rows = $menu->getElementsByTagName('tr');
$json = [];
foreach($rows as $row) {
	$day;
	$rowTag = $row->childNodes->item(0)->tagName;
	if (strcmp($rowTag, 'th') == 0) {
		if(!empty($day)) {
                    $json[] = $day;
		}
		$day = new Day();
		$day->day = $row->nodeValue;
	} else {
		$cells = $row->getElementsByTagName('td');
		$food = new Food();
		$food->name = $cells->item(0)->nodeValue;
		$food->price = $cells->item(1)->nodeValue;
		$day->foods[] = $food;
	}
    if(empty($day->foods)) {
        continue;
    }
    
    $sql = "INSERT INTO formanka ( name, price ) VALUES ('$food->name', '$food->price');";
    mysql_select_db($db);
    mysql_query($sql) or die(mysql_error());
}
mysql_close();
