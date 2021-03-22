<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnBanuj'])){

    $data = [];
    if(!isset($_POST['korisnik']) || $_POST['korisnik'] == ''){
        $data['poruka'] = "Korisnik nije izabran.";

        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $korId = $_POST['korisnik'];

        if(!jeBanovan($korId)){
            if(banujKorisnika($korId)){
                $data['poruka'] = "Korisnik je uspesno banovan.";

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
            $data['poruka'] = "Korisnik je vec banovan.";

            http_response_code(400);
            echo json_encode($data);
        }
    }
}
else{
    header('location: ../../404.php');
}