<?php
ob_start();
session_start();

require_once '../../setup/konekcija.php';

if(isset($_POST['ulogujKorisnika'])){

    $korisnickoIme = $_POST['korIme-login'];
    $lozinka = md5($_POST['lozinka-login']);

    $upit = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_korisnicko_ime = :korIme AND korisnik_lozinka = :loz');

    $upit->bindParam(':korIme', $korisnickoIme);
    $upit->bindParam(':loz', $lozinka);

    $upit->execute();

    if($upit->rowCount() == 1){

        $korisnik = $upit->fetch();
        
        if($korisnik->korisnik_status_id == 2){
            $_SESSION['greskeLogin'] = "Nalog je banovan.";
            header('location: ../../login.php');
        }
        else if($korisnik->korisnik_status_id == 3){
            $_SESSION['greskeLogin'] = "Nalog nije aktiviran.";
            header('location: ../../login.php');
        }
        else{
            $_SESSION['korisnik'] = $korisnik;

            if($korisnik->korisnik_uloga_id == 1){
                header('location: ../../admin.php');
            }
            else if($korisnik->korisnik_uloga_id == 5){
                header('location: ../../autorVesti.php');
            }
            else{
                header('location: ../../index.php');
            }
        }
    }
    else{
        $_SESSION['greskeLogin'] = "Uneto korisnicko ime i lozinka se ne poklapaju.";
        header('location: ../../login.php');
    }
}
else{
    header('location: ../../404.php');
}
