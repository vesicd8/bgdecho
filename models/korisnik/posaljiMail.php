<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnKontaktiraj'])){
    $ime = $_POST['ime'];
    $email = $_POST['email'];
    $poruka = $_POST['poruka'];
    $naslov = $_POST['naslov'];
    $greske = [];
    if(!preg_match("/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/", $ime)){
        array_push($greske, "Ime mora početi velikim slovom i ne sme imati specijalne karaktere.");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($greske, "Email nije ispravno unet.");
    }
    if(strlen($naslov) < 5 ){
        array_push($greske, "Naslov ne sme da bude kraći od 5 karaktera.");
    }
    if(strlen($naslov) > 30 ){
        array_push($greske, "Naslov mora da bude kraći od 30 karaktera.");
    }
    if(empty($poruka)){
        array_push($greske, "Poruka ne sme da ostane prazna.");
    }
    if(strlen($poruka) > 350){
        array_push($greske, "Poruka ne sme da bude duza od 350 karaktera.");
    }

    if(count($greske) == 0){
        $data['poruka'] = "Poruka je uspesno poslata";

        http_response_code(200);
        echo json_encode($data);
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