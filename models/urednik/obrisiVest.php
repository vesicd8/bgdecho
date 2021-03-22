<?php

ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnObrisiVest'])){
    $data = [];
    if(!isset($_POST['vestId']) || $_POST['vestId'] == ''){
        $data['poruka'] = "Morate izabrati vest.";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $vestId = $_POST['vestId'];

        if(!idVestiPostoji($vestId)){
            $data['poruka'] = "Izabrana vest ne postoji.";
            http_response_code(400);
            echo json_encode($data);
        }
        else{
            $upit = $connection->prepare('DELETE FROM vesti WHERE vest_id = :vest');
            $upit->bindParam(':vest', $vestId);
            $rez = $upit->execute();

            if($rez){
                $data['poruka'] = "Vest uspesno obrisana.";
                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $data['poruka'] = "Doslo je do greske pri brisanju, molimo pokusajte kasnije.";
                http_response_code(400);
                echo json_encode($data);
            }
        }
    }
}
else{
    header('location: ../../404.php');
}