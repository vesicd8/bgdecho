<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['ddlKatPromena'])){
    $data = [];
    if(!isset($_POST['katId']) || $_POST['katId'] == ''){
        $data['poruka'] = "Morate izabrati kategoriju.";
        $data['tekst'] = "";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $katId = $_POST['katId'];

        $kategorija = kategorijaInfo($katId);

        if($kategorija != null){
            $data['kategorija'] = $kategorija;
            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $data['poruka'] = "Izabrali ste nepostojacu kategoriju.";
            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else if(isset($_POST['btnIzmeniKategoriju'])){
    $greske = [];
    $data = [];
    if(!isset($_POST['kategorija']) || $_POST['kategorija'] == ''){
        array_push($greske, "Morate izabrati kategoriju koju zelite da izmenite.");

        $data['greske'] = $greske;

        http_response_code(400);
        echo json_encode($data);
    }
    else{
        if($_POST['novaRodKat'] == ''){
            $rodKat = null;
        }
        else{
            $rodKat = $_POST['novaRodKat'];
        }
        $kategorija = $_POST['kategorija'];
        $novaRodKat = $_POST['novaRodKat'];
        $novoImeKat = $_POST['novoImeKat'];

        $kategorijaInfo = kategorijaInfo($kategorija);

        if($kategorija == $novaRodKat){
            array_push($greske, "Kategorija ne moze biti roditelj sama sebi.");
        }
        if($kategorijaInfo->kategorija_naziv == $novoImeKat && $kategorijaInfo->roditelj_id == $novaRodKat){
            array_push($greske, "Morate izmeniti bar jednu stavku.");
        }
        if(jeRoditelj($kategorijaInfo->kategorija_id)){
            array_push($greske, "Izabrana kategorija je roditelj i ne moze imati roditelja");
        }

        if(count($greske) == 0){
            if(izmeniKategoriju($kategorija, $novoImeKat, $rodKat)){
                $data['poruka'] = "Kategorija uspesno izmenjena";
                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $data['greske'] = array("Kategorija uspesno izmenjena");
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
}
else if(isset($_POST['btnUkloniKategoriju'])){
    $data=[];
    if(!isset($_POST['katZaBrisanje']) || $_POST['katZaBrisanje'] == ''){
        $data['poruka'] = "Morate izabrati kategoriju.";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $katId = $_POST['katZaBrisanje'];
        $katInfo = kategorijaInfo($katId);
        if($katInfo != null){
            $upit = $connection->prepare('DELETE FROM kategorije_vesti WHERE kategorija_id = :kat');
            $upit->bindParam(':kat', $katId);
            $rez = $upit->execute();
            if($rez){
                $data['poruka'] = "Kategorija uspesno obrisana.";
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
            $data['poruka'] = "Kategorija ne postoji, molimo izaberite drugu.";
            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else{
    header('location: ../../404.php');
}