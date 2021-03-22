<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['izmeniOdgovore']) && $_SESSION['korisnik']->korisnik_uloga_id == 1){
    $anketaId = $_POST['anketaId'];

    $odgovori = anketeOdgovori($anketaId);

    if(count($odgovori) != 0){
        $data['odgovori'] = $odgovori;
        http_response_code(200);
        echo json_encode($data);
    }
    else if($anketaId == ''){
        $data['poruka'] = "Morate izabrati anketu.";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $data['poruka'] = "Za ovu anketu nije dodat nijedan odgovor.";
        http_response_code(400);
        echo json_encode($data);
    }
}
else if(isset($_POST['btnIzmeniOdgovor'])){
    $data = [];
    $greske = [];
    $odgId = $_POST['odgId'];
    $odgovor = odgovor($_POST['odgId']);

    if(!isset($_POST['noviOdg']) || $_POST['noviOdg'] == '' || strlen($_POST['noviOdg']) < 5){
        array_push($greske, "Novi odgovor ne sme ostati prazan i ne sme biti kraci od 5 karaktera");
    }
    else{
        $noviOdg = $_POST['noviOdg'];

        if($noviOdg == $odgovor->odgovor){
            array_push($greske, "Novi odgovor ne sme biti isti kao trenutni.");
        }
    }

    if(count($greske) == 0){

        $upit = $connection->prepare('UPDATE anketa_odgovori SET odgovor = :novi WHERE odgovor_id = :odgId');
        $upit->bindParam(':novi', $noviOdg);
        $upit->bindParam(':odgId', $odgId);
        $rez = $upit->execute();
        if($rez){
            $data['poruka'] = "Odgovor je uspesno izmenjen.";
            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $data['greske'] = array("Doslo je do greske pri menjanju odgovora, molimo vas pokusajte kasnije.");
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