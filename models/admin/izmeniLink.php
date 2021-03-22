<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnIzmeniLink'])){
    $link = $_POST['linkId'];

    if($link == ''){
        $data['poruka'] = "Morate izabrati link";

        http_response_code(400);
        echo json_encode($data);
    }
    else{
        $obj = linkInformacije($link);

        http_response_code(200);
        echo json_encode($obj);
    }
}
else if(isset($_POST['btnUkloniLink'])){
    $link = $_POST['linkId'];

    if($link == ''){
        $data['poruka'] = "Morate izabrati link";
        http_response_code(400);
        echo json_encode($data);
    }
    else{
        ukloniLink($link);
        $data['poruka'] = "Link uspesno obrisan";
        http_response_code(200);
        echo json_encode($data);
    }
}
else if(isset($_POST['btnSacuvajIzmeneLink'])){
    $greske = 0;
    if(!isset($_POST['linkTekst']) || empty($_POST['linkTekst'])){
        $greske++;
    }
    if(!isset($_POST['href']) || empty($_POST['href'])){
        $greske++;
    }
    if(!isset($_POST['prioritet']) || empty($_POST['prioritet'])){
        $greske++;
    }
    if(!isset($_POST['title'])){
        $greske++;
    }
    if(!isset($_POST['id']) || empty($_POST['id'])){
        $greske++;
    }
    if($greske == 0){
        izmeniLink($_POST['linkTekst'], $_POST['href'], $_POST['title'], $_POST['prioritet'], $_POST['id']);
        http_response_code(200);
        echo json_encode("Link uspesno izmenjen.");
    }
    else{
        http_response_code(400);
        echo json_encode("Morate uneti sve potrebne podatke");
    }
}
else{
    header('location: ../../404.php');
}