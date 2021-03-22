<?php
ob_start();
session_start();

require_once '../../setup/konekcija.php';

require_once '../funkcije.php';

if(isset($_POST['izmeniVest']) && $_SESSION['korisnik']->korisnik_uloga_id == 5){

    $idVesti = $_POST['idv'];
    $naslov = $_POST['naslov'];
    $tekst = $_POST['tekst'];
    $kat = $_POST['kategorija-vesti'];
    $alt = $_POST['izmeniAlt'];

    $updateVest = $connection->prepare("UPDATE vesti SET vest_naslov = :naslov, vest_tekst = :tekst, vest_kategorija_id = :kat WHERE vest_id = :id");
    $updateVest->bindParam(':naslov', $naslov);
    $updateVest->bindParam(':tekst', $tekst);
    $updateVest->bindParam(':kat', $kat);
    $updateVest->bindParam(':id', $idVesti);
    
    $updateAlt = $connection->prepare("UPDATE slike SET slika_alt = :alt WHERE vest_id = :id");
    $updateAlt->bindParam(':alt', $alt);
    $updateAlt->bindParam(':id', $idVesti);

    $rezAlt = $updateAlt->execute();
    $rezVest = $updateVest->execute();



    if($rezVest && $rezAlt){
        $_SESSION['izmeniVestPoruka'] = "Vest uspesno izmenjena.";
        header("location: ../../urediVest.php?id=$idVesti");
    }
    else{
        $_SESSION['izmeniVestGreska'] = "Doslo je do greske, molimo pokusajte kasnije.";
        header("location: ../../urediVest.php?id=$idVesti");
    }


}
else if(isset($_POST['izmeniSliku']) && $_SESSION['korisnik']->korisnik_uloga_id == 5){

    $greske = [];
    $brojGresaka = 0;
    $idVesti = $_POST['idv'];
    $brUploadovanihSlika = 0;

    $XLTemp = $_FILES['XL']['name'];
    $LTemp = $_FILES['L']['name'];
    $SMTemp = $_FILES['SM']['name'];


    if($XLTemp != ''){
        $XL = $_FILES['XL'];
        $XLsrc = proveriSliku($XL, 'xl-', true);
        if($XLsrc != null){
            upisi($XLsrc, 'slika_xl', $idVesti);
            ++$brUploadovanihSlika;
        }
    }

    if($LTemp != ''){
        $L = $_FILES['L'];
        $Lsrc = proveriSliku($L, 'l-', true);
        if($Lsrc != null){
            upisi($Lsrc, 'slika_l', $idVesti);
            ++$brUploadovanihSlika;
        }
    }

    if($SMTemp != ''){
        $SM = $_FILES['SM'];
        $SMsrc = proveriSliku($SM, 'sm-', true);
        if($SMsrc != null){
            upisi($SMsrc, 'slika_sm', $idVesti);
            ++$brUploadovanihSlika;
        }
    }

    if($brUploadovanihSlika != 0){

        $_SESSION['izmeniSlikePoruka'] = "Stavke su uspesno izmenjene.";
        header("location: ../../urediVest.php?id=$idVesti");
    }
    else{
        $_SESSION['brojUloadovanihSlika'] = "Nijedan fajl nije uploadovan";
        if(isset($_SESSION['slikeUpload'])){
            $_SESSION['izmeniSlikeGreske'] = $_SESSION['slikeUpload'];
            unset($_SESSION['slikeUpload']);
        }
        header("location: ../../urediVest.php?id=$idVesti");
    }
}
else{
    header('location: ../../404.php');
}

