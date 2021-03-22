<?php
    $server = 'localhost';
    $dbName = 'bgd_echo';
    $userName = 'root';
    $password = '';

    try {
        $connection = new PDO('mysql:host='.$server.';dbname='.$dbName.';charset=utf8', $userName, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    } catch (PDOException $ex) {

        echo "Konekcija sa bazom nije uspešna.";

    }
