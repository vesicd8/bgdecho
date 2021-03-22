<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnKreirajAnketu'])){

    if(!isset($_POST['pitanje']) || $_POST['pitanje'] == '' || strlen($_POST['pitanje']) < 10){
        $data['poruka'] = "Pitanje ne sme da ostane prazno ili da bude krace od 10 karaktera";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $pitanje = $_POST['pitanje'];
        
        if(novaAnketa($pitanje)){
            $data['poruka'] = "Anketa je uspesno napravljena.";

            echo json_encode($data);
        }
        else{
            $data['poruka'] = "Doslo je do greske pri kreiranju ankete, molimo vas pokusajte kasnije.";
            http_response_code(400);
            echo json_encode($data);
        }

    }
}
else{
    header('location: ../../404.php');
}