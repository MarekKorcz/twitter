<?php

// zabezpieczenie przed wejsciem nie zaologowanym
require_once 'require_components/ifLogged.php';

// zabezpieczenie przed wejscie bez sprecyzowanego id wiadomosci
if(!isset($_GET['message_id'])){
    exit();
}

require_once 'src/Connection.php';
require_once 'src/Message.php';


// ustawienie $switch na 0

// wyswietlenie calej wiadomosci razem z odbiorca

?>