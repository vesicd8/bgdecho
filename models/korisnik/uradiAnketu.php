<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnUradiAnketu'])){
    $grekse = 0;
    if(!isset($_POST['anketaid']) || empty($_POST['anketaid'])){
        $grekse++;
    }
    if(!isset($_POST['anketaOdg']) || empty($_POST['anketaOdg'])){
        $grekse++;
    }
    if(!isset($_SESSION['korisnik'])){
        $grekse++;
    }
    if($grekse == 0){
        $korisnik = $_SESSION['korisnik']->korisnik_id;
        $anketaId = $_POST['anketaid'];
        $anketaOdg = $_POST['anketaOdg'];

        odradiAnketu($korisnik, $anketaId, $anketaOdg);
        
        http_response_code(200);
        echo json_encode("Anketa odradjena.");
    }
    else{
        http_response_code(400);
        echo json_encode("Morate uneti odgovor.");
    }
}
else{
    header('location: ../../404.php'); 
}