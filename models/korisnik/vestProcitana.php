<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['vestProcitana'])){
    $vestid = $_POST['vestId'];

    $vest = vestInfo($vestid);

    if($vest != null){
        $brPregleda = $vest->broj_pregleda+1;
        $upit = $connection->prepare('UPDATE vesti SET broj_pregleda = :brPregleda WHERE vest_id = :id');
        $upit->bindParam(':brPregleda', $brPregleda);
        $upit->bindParam(':id', $vestid);
        $rez = $upit->execute();
    }
    else{
        http_response_code(400);
    }
}
else{
    header('location: ../../404.php'); 
}