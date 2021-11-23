<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';
// 1. pobranie parametrów

$x = $_REQUEST ['x'];
$y = $_REQUEST ['y'];
$oprocentowanie = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($x) && isset($y) && isset($oprocentowanie))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $x == "") {
	$messages [] = 'Nie podano kwoty';
}
if ( $y == "") {
	$messages [] = 'Nie podano czasu';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $x )) {
		$messages [] = 'Błędna wartość kwoty.';
	}
	
	if (! is_numeric( $y )) {
		$messages [] = 'Błędna wartość lat.';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$x = intval($x);
	$y = intval($y);
	
	//wykonanie operacji
	switch ($oprocentowanie) {
		case '10%' :
            if ($role == 'admin'){
			$result = ($x / ($y * 12)) * 1.1;
            } else {
            $messages [] = 'Tylko administrator może obliczać ratę kredytu!';
			}
			break;
		case '15%' :
            if ($role == 'admin'){
			$result = ($x / ($y * 12)) * 1.15;
            } else {
            $messages [] = 'Tylko administrator może obliczać ratę kredytu!';
			}
			break;
		case '20%' :
            if ($role == 'admin'){
			$result = ($x / ($y * 12)) * 1.2;
            } else {
            $messages [] = 'Tylko administrator może obliczać ratę kredytu!';
			}
			break;
		default :
            if ($role == 'admin'){
			$result = ($x / ($y * 12)) * 1.05;
            } else {
            $messages [] = 'Tylko administrator może obliczać ratę kredytu!';
			}
			break;
	}
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$oprocentowanie,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
