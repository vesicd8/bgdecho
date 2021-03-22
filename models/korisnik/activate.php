<?php
ob_start();
session_start();

require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_GET['kod'])){

    $kod = $_GET['kod'];

    $aktivanNalog = aktivirajNalog($kod);

    if($aktivanNalog){
        $_SESSION['nalogAktiviran'] = "Nalog je uspesno aktiviran.";
        header('location: ../../login.php');
    }
    else{
        header('location: ../../404.php');
    }

}
else{
    header('location: ../../404.php');
}
