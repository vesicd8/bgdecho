<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnKreirajNoviLink'])){
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
    if($greske == 0){
        kreirajNoviLink($_POST['linkTekst'], $_POST['href'], $_POST['title'], $_POST['prioritet']);
        http_response_code(200);
        echo json_encode("Link uspesno kreiran.");
    }
    else{
        http_response_code(400);
        echo json_encode("Morate uneti sve potrebne podatke");
    }
}
else{
    header('location: ../../404.php');
}