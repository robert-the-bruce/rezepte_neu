<?php

$databasename = 'rezepte_neu';
$username = 'root';
$password = '';


try {
    $con = new PDO('mysql:host=localhost;dbname=' . $databasename, $username, $password);

} catch (exception $e) {
    $e->getMessage();

    switch ($e->getCode()) {

        case 2002:
            echo 'Verbindung zum Server nicht möglich!<br>';
            break;
        case 1044:
            echo 'Probleme beim Zugriff mit Benutzer: <b>' . $username . '</b>';
            break;
        case 1045:
            echo 'Passwort evt. falsch für Benutzer: ' . $username . '! Zugriff abgelehnt!<br>';
            break;
        case 1049:
            echo 'Die Datenbank <b>' . $databasename . '</b> existiert nicht!<br>';
            break;
        default:
            echo $e->getMessage();
    }
}