<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnAktivirajAnketu'])){
    $data = [];
    $akt = 1;
    if(!isset($_POST['anketaId']) || $_POST['anketaId'] == ''){
        $data['poruka'] = "Morate izabrati anketu.";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $anketaId = $_POST['anketaId'];

        if(!jeAktivna($anketaId)){

            deaktivirajSveAnkete();
    
            $upit = $connection->prepare('UPDATE anketa SET aktivna = :akt WHERE anketa_id = :aId');
            $upit->bindParam(':akt', $akt);
            $upit->bindParam(':aId', $anketaId);
            $rez = $upit->execute();
            if($rez){
                $data['poruka'] = "Anketa je uspesno aktivirana.";
                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $data['poruka'] = "Doslo je do greske, molimo pokusajte kasnije.";
                http_response_code(400);
                echo json_encode($data);
            }
        }
        else{
            $data['poruka'] = "Izabrana anketa je vec aktivna.";
            http_response_code(400);
            echo json_encode($data);
        }
    }


}
else if(isset($_POST['btnUkloniAnketu'])){
    $data = [];

    if(!isset($_POST['anketaId']) || $_POST['anketaId'] == ''){
        $data['poruka'] = "Morate izabrati anketu.";
        http_response_code(400);
        echo json_encode($data);

    }
    else{
        $anketaId = $_POST['anketaId'];
        $upit = $connection->prepare('DELETE FROM anketa WHERE anketa_id = :id');
        $upit->bindParam(':id', $anketaId);
        $rez = $upit->execute();
        if($rez) {
            $data['poruka'] = "Anketa je uspesno uklonjena.";
            http_response_code(200);
            echo json_encode($data);
        }
        else {

            $data['poruka'] = "Doslo je do greske pri brisanju, molimo pokusajte kasnije.";
            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else if(isset($_POST['btnDeaktivirajSveAnkete'])){
    $data = [];
    deaktivirajSveAnkete();

    $data['poruka'] = "Sve ankete su uspesno deaktivirane.";
    http_response_code(200);
    echo json_encode($data);    
}
else{
    header('location: ../../404.php');
}