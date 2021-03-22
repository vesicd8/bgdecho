<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnPromeniUlogu'])){

    $data = [];
    if(!isset($_POST['korisnik']) || $_POST['korisnik'] == '' || !isset($_POST['ulogaId']) || $_POST['ulogaId'] == ''){
        $data['poruka'] = "Korisnik ili uloga nije izabrana.";

        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $korId = $_POST['korisnik'];
        $ulogaId = $_POST['ulogaId'];
        if(!imaUlogu($korId, $ulogaId)){
            if(promeniUlogu($korId, $ulogaId)){
                $data['poruka'] = "Uloga je uspesno izmenjena.";

                http_response_code(200);
                echo json_encode($data);
            }
            else{
                $data['poruka'] = "Doslo je do greske, molimo vas pokusajte kasnije.";

                http_response_code(400);
                echo json_encode($data);
            }
        }
        else{
            $data['poruka'] = "Korisnik vec ima izabranu ulogu.";

            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else{
    header('location: ../../404.php');
}