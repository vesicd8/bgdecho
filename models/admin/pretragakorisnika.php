<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';

if(isset($_POST['btnPretraga']) && $_SESSION['korisnik']->korisnik_uloga_id = 1){
    $greske = [];
    $data = [];
    $pretragaVal = strtolower($_POST['pretraga']);

    if($pretragaVal == ''){
        array_push($greske, "Kriterijum za pretragu korisnika ne sme biti prazan.");
    }

    if(count($greske) == 0){
        $adminId = 7;
        $banovan = 2;
        $pretraga = $connection->prepare("SELECT * FROM korisnik WHERE LOWER(korisnik_korisnicko_ime) LIKE :user AND korisnik_id <> :br AND korisnik_status_id <> :ban");

        $pretragaVal = "%".$pretragaVal."%";
        
        $pretraga->bindParam(':user', $pretragaVal);
        $pretraga->bindParam(':br', $adminId);
        $pretraga->bindParam(':ban', $banovan);
        
        $rez = $pretraga->execute();

        $count = $pretraga->rowCount();

        
        if($rez){
            if($pretraga->rowCount() != 0){
                $obj = $pretraga->fetchAll();
                $data['korisnici'] = $obj;
    
                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $data['poruka'] = "Nema rezultata za unet kriterijum.";
                http_response_code(400);
                echo json_encode($data);
            }
        }
    }
    else{
        $data['poruka'] = "Kriterijum za pretragu korisnika ne sme biti prazan.";
        http_response_code(400);
        echo json_encode($data);
    }
}
else{
    header('location: ../../404.php');
}