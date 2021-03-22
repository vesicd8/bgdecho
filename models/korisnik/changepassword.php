<?php
ob_start();

session_start();

header('Content-type: application/json');

require_once '../funkcije.php';

if(isset($_POST['btnPromena']) && isset($_SESSION['korisnik'])){

    $korIme = $_SESSION['korisnik']->korisnik_korisnicko_ime;
    $lozinkaEnc = md5($_POST['trenutna']);
    $novaEnc = md5($_POST['nova']);
    $potvrdiLozEnc = md5($_POST['potvrdi']);

    $lozinka = $_POST['trenutna'];
    $nova = $_POST['nova'];
    $potvrdiLoz = $_POST['potvrdi'];

    $passwordRe = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    $data = [];
    $greske = [];

    require_once '../../setup/konekcija.php';

    $provera = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_korisnicko_ime = :kIme AND korisnik_lozinka = :loz');

    $provera->bindParam(':kIme', $korIme);
    $provera->bindParam(':loz', $lozinkaEnc);

    $rezProvera = $provera->execute();

    if($rezProvera && $provera->rowCount() == 1){
        if($lozinka == $nova){
            array_push($greske, "Nova lozinka ne sme biti ista kao trenutna.");
        }
        if($nova !=$potvrdiLoz){
            array_push($greske, "Lozinke se ne poklapaju.");
        }
        if(!preg_match($passwordRe, $nova)){
            array_push($greske, "Lozinka nije dobrog formata.");
        }
        if(count($greske) == 0){

            if(promeniLozinku($novaEnc, $lozinkaEnc, $korIme)){
                unset($_SESSION['korisnik']);
                $_SESSION['promenjenaLozinka'] = "Lozinka je uspešno promenjena.";
                http_response_code(204);
            }
            else{
                array_push($greske, "Doslo je do greške, molimo vas pokušajte kasnije.");
                $data['greske'] = $greske;
                http_response_code(500);
                echo json_encode($data);
            }
        }
        else{
            $data['greske'] = $greske;
            http_response_code(400);
            echo json_encode($data);
        }
    }
    else{
        array_push($greske, "Korisničko ime i lozinka se ne poklapaju, molimo vas pokušajte ponovo.");
        $data['greske'] = $greske;
        http_response_code(400);
        echo json_encode($data);
    }
}
else{
    header('location: ../../404.php');
}