<?php
ob_start();
session_start();

if(isset($_SESSION['korisnik'])){
    unset($_SESSION['korisnik']);
    header('location: ../../index.php');
}
else{
    header('location: ../..404.php');
}