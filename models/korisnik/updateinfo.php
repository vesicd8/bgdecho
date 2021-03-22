<?php
session_start();

header("Content-type: application/json");

require_once '../funkcije.php';

if(isset($_POST['btnIzmeni']) && isset($_SESSION['korisnik'])){
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_SESSION['korisnik']->korisnik_korisnicko_ime;
    $password = $_POST['lozinka'];
    $email = $_POST['email'];

    $data = [];
    $greske = [];
    $lozinka = md5($password);
    $kod = md5($username. sha1(time(). $email));

    require_once '../../setup/konekcija.php';

    $imeRe = "/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/";
    $prezimeRe = &$imeRe;
    $passwordRe = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    $upit = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_korisnicko_ime = :kor AND korisnik_lozinka = :loz');

    $upit->bindParam(':kor', $username);
    $upit->bindParam(':loz', $lozinka);

    $rez = $upit->execute();

    if($rez && $upit->rowCount() == 1){
        $obj = $upit->fetch();

        if($email != $obj->korisnik_email){
            
            if(!emailPostojiUBazi($email)){
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    array_push($greske, "Email je loseg formata.");
                }
            }
            else{
                array_push($greske, "Unet email je vec u upotrebi.");
            }

        }
        if(!preg_match($imeRe, $ime)){
            array_push($greske, "Ime nije ispravno uneto.");
        }
        if(!preg_match($prezimeRe, $prezime)){
            array_push($greske, "Prezime nije ispravno uneto.");
        }

        if(count($greske) == 0){
            $update = $connection->prepare(
                'UPDATE korisnik 
                 SET korisnik_ime = :ime, korisnik_prezime = :prezime, korisnik_email = :mail, aktivacioni_kod = :kod 
                 WHERE korisnik_korisnicko_ime = :korIme AND korisnik_lozinka = :loz');
            
            $update->bindParam(':ime', $ime);
            $update->bindParam(':prezime', $prezime);
            $update->bindParam(':mail', $email);
            $update->bindParam(':kod', $kod);
            $update->bindParam(':korIme', $username);
            $update->bindParam(':loz', $lozinka);

            $updateRez = $update->execute();

            if($updateRez){
                $data['poruka'] = "Nalog uspesno izmenjen.";
                resetujSesiju($username, $lozinka);
                http_response_code(200);
                echo json_encode($data);
            }
            else{
                array_push($greske, "Doslo je do greske, molimo vas pokusajte kasnije ili kontaktirajte administratora.");
                $data['greske'] = $greske;
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
        array_push($greske, "Lozinka nije ispravno uneta, molimo pokusajte ponovo.");
        $data['greske'] = $greske;
        http_response_code(400);
        echo json_encode($data);
    }
}
else{
    header('location: ../../404.php');
}