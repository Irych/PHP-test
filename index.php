<?php
class Valute {
	public $url;
	public $id;

	public function __construct($url, $id) {
		$this->url = $url;
		$this->id = $id;
	}

	public function getEurValue($url, $id){
		$data = simplexml_load_file($url);  // загрузка файла
		$courses = $data -> xpath("//Valute[@ID='$id']");  // поиск нужной валюты по id
		$value = strval($courses[0]->Value);  // преобразование значения в строку

		return $value;
	}

	public function compare($current, $prev){
		if ($current > $prev) {
			return ' ▲';
		}
		if ($current < $prev) {
			return ' ▼';
		}
	}

}

$today = new Valute("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"), "R01239");  // создание объекта класса Valute со значением на текущую дату
$value = $today->getEurValue($today->url, $today->id); // использование метода класса Valute для получения значения валюты

$yesterday = new Valute("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y", strtotime("-1 DAY")), "R01239"); // создание объекта класса Valute со значением на предыдущую дату
$prev_value = $yesterday->getEurValue($yesterday->url, $yesterday->id);

$rates = $today->compare($value, $prev);  // изменение курса относительно предыдущего дня
echo "EUR:".$value.$rates;

?>