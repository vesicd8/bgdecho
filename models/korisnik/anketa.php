<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['proveriAnketu'])){
    if(isset($_SESSION['korisnik'])){
        $korisnik = $_SESSION['korisnik'];
        $anketa = aktivnaAnketa();

        if($anketa != null && $korisnik->korisnik_uloga_id == 8){
            if(odradioAnketu($korisnik->korisnik_id, $anketa->anketa_id)){
                $data['odradjeno'] = true;

                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $anketaOdg =  anketeOdgovori($anketa->anketa_id);
                $data['odradjeno'] = false;
                $data['anketaPitanje'] = $anketa;
                $data['anketaOdg'] = $anketaOdg;

                http_response_code(200);
                echo json_encode($data);
            }
        }
        else{
            http_response_code(400);
            echo json_encode("Nema aktivnih anketa/nije regularan korisnik");
        }
    }
    else{
        http_response_code(400);
        echo json_encode("Korisnik nije ulogovan");
    }
    
}
else{
    header('location: ../../404.php'); 
}