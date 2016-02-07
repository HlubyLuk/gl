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
header("Content-Type: text/plain");
header('Content-Type: application/json');

$endPoint = 'http://www.originalformanka.cz/1-denni-menu/';
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
}
echo json_encode($json, false);
?>
