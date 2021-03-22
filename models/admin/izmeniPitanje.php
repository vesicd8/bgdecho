<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['izmeniPitanjeDdl']) && $_SESSION['korisnik']->korisnik_uloga_id == 1){
    $anketa = $_POST['anketaId'];
    $upit = $connection->prepare("SELECT * FROM anketa WHERE anketa_id = :ank");

    $upit->bindParam(':ank', $anketa);

    $upit->execute();

    $count = $upit->rowCount();

    if($count == 1){
        $obj = $upit->fetch();

        $data['pitanje'] = $obj;
        http_response_code(200);
        echo json_encode($data);
    }
    else{   
        $data['poruka'] = "Izabrana anketa ne postoji";
        http_response_code(400);
        echo json_encode($data);
    }
}
else if(isset($_POST['btnIzmeniAnketu'])){

    $greske = [];
    $data = [];

    if(!isset($_POST['anketaId']) || $_POST['anketaId'] == ''){
        array_push($greske, 'Anketa nije izabrana.');
    }
    if(!isset($_POST['novoPitanje']) || $_POST['novoPitanje'] == ''){
        array_push($greske, 'Pitanje ne sme da ostane prazno.');
    }
    else if(strlen($_POST['novoPitanje']) < 10){
        array_push($greske, 'Pitanje ne sme biti krace od 10 karaktera.');
    }

    if(count($greske) == 0){
        $anketaId = $_POST['anketaId'];
        $novoPitanje = $_POST['novoPitanje'];

        if(izmeniAnketu($anketaId, $novoPitanje)){
            $data['poruka'] = "Anketa uspesno izmenjena";
            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $data['greske'] = array("Doslo je do greske pri izmeni anketa, molimo pokusajte kasnije.");
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