<?php
header("Content-type: application/json");
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnRegistruj'])){
    

    $greske = [];
    $data = [];
    $registrujIme = $_POST['ime'];
    $registrujPrezime = $_POST['prezime'];
    $registrujKorisnickoIme = $_POST['username'];
    $registrujLozinku = $_POST['lozinka'];
    $lozinkaProvera = $_POST['proveraLozinke'];
    $registrujEmail = $_POST['email'];


    $upit = $connection -> prepare('SELECT * FROM korisnik WHERE korisnik_korisnicko_ime = :korIme');
    $upit->bindparam(':korIme', $registrujKorisnickoIme);
    $rez = $upit -> execute();
    $count = $upit -> rowCount();


    $imeRe = "/^[A-Z]+(([a-zA-Z ])?[a-zA-Z]*)*$/";
    $prezimeRe = $imeRe;
    $usernameRe = "/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
    $passwordRe = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    if(!preg_match($imeRe, $registrujIme)){
        array_push($greske, "Ime ne sme da sadrži brojeve, specijalne karaktere ili da ostane prazno i mora početi velikim slovom.");
    }
    if(!preg_match($prezimeRe, $registrujPrezime)){
        array_push($greske, "Prezime ne sme da sadrži brojeve, specijalne karaktere ili da ostane prazno.");
    }
    if(!preg_match($usernameRe, $registrujKorisnickoIme)){
        array_push($greske, "Korisničko ime mora biti minimalne dužine od 8 karaktera, mora da ima bar jedan broj i ne sme da sadrži specijalne karaktere.");
    }
    if($count != 0){
        array_push($greske, "Korisnicko ime već postoji");
    }
    if(!preg_match($passwordRe, $registrujLozinku)){
        array_push($greske, "Lozinka mora da ima minimum 8 karaktera i mora da sadrži bar jedan broj.");
    }
    if($registrujLozinku != $lozinkaProvera){
        array_push($greske, "Unete lozinke se ne podudaraju.");
    }
    if(!filter_var($registrujEmail, FILTER_VALIDATE_EMAIL)){
        array_push($greske, "Email nije ispravan.");
    }
    if(emailPostojiUBazi($registrujEmail)){
        array_push($greske, "Email je zauzet.");
    }
    if(count($greske) == 0){
        if(registruj($registrujIme, $registrujPrezime, $registrujKorisnickoIme, $registrujEmail, $registrujLozinku)){
            $data['poruka'] = "Vaš nalog je uspešno kreiran. Kako bi pristup nalogu bio omogućen, molimo vas potvrdite registraciju klikom na link ispod.";
            $data['aktivacioniKod'] = aktivacioniKod($registrujKorisnickoIme);
            http_response_code(201);
            echo json_encode($data);
        }
        else{
            $data["greske"] = "Doslo je do greške pri registraciji, molimo pokušajte kasnije.";
            http_response_code(400);
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
    header('location: ../../404.php');
}