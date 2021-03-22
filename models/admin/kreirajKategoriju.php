<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['roditeljId'])){

    if(!isset($_POST['imeKat']) || $_POST['imeKat'] == ''){
        $data['poruka'] = "Morate uneti ime kategorije.";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $novaKatIme = $_POST['imeKat'];
            if($_POST['roditeljId'] == ''){
                $roditeljId = null;
            }
            else{
                $roditeljId = $_POST['roditeljId'];
            }
        if(!kategorijaPostoji($novaKatIme)){
            $upit = $connection->prepare("INSERT INTO kategorije_vesti (kategorija_id, kategorija_naziv, roditelj_id)
            VALUES (null, :naziv, :rod)");
            $upit->bindParam(':naziv', $novaKatIme);
            $upit->bindParam(':rod', $roditeljId);
            $upit->execute();

            $data['poruka'] = "Kategorija uspesno kreirana.";
            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $data['poruka'] = "Kategorija sa tim imenom vec postoji.";
            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else{
    header('location: ../../404.php');
}