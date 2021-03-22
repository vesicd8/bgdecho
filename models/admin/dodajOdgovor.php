<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnDodajOdgovor']) && $_SESSION['korisnik']->korisnik_uloga_id == 1){
    $greske = [];
    if(!isset($_POST['pitanje']) || $_POST['pitanje'] == ''){
        array_push($greske, "Morate izabrati anketu za koju zelite da dodate odgovor.");
    }
    if(!isset($_POST['odgovor']) || $_POST['odgovor'] == '' || strlen( $_POST['odgovor']) < 5){
        array_push($greske, "Odgovor ne sme da ostane prazan ili da bude kraci od 5 karaktera.");
    }

    if(count($greske) == 0){
        $anketaId = $_POST['pitanje'];
        $odgovor = $_POST['odgovor'];

        if(dodajOdgovor($anketaId, $odgovor)){
            $data['poruka'] = "Odgovor je uspesno dodat.";
            http_response_code(200);
            echo json_encode($data);
        }
        else{

            $data['greske'] = array("Doslo je do greske, molimo pokusajte kasnije.");
            http_response_code(400);
            echo json_encode($data);
        }

    }
    else{

        $data['greske'] = $greske;
        http_response_code(400);
        echo json_encode($data);
    }
}
else{
    header('location: ../../404.php');
}