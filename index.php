<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

function pr($what)
{
	return '<pre>' . print_r($what, true) . '</pre>';
}

spl_autoload_register(function($class) {
	$filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

	require_once($filename);
});

/*
 * PHP history
 */
$a = [
	"voornaam" => "Sebastiaan",
	"achternaam" => "Francken",
	"adres" => "Klaaslaan",
	"postcode" => "1234 AA",
	"telefoonnummer" => "123456789",
	"emailadres" => "klaas@laan.nl"
];

$b = [
	"voornaam" => "Sebastiaan",
	"achternaam" => "Franken",
	"adres" => "Klaaslaan 1044",
	"postcode" => "1234 AA",
	"telefoonnummer" => "123456789",
	"vrijwilliger" => "ja"
];

$diff = new Diff($a, $b);
print pr($diff->toArray());
