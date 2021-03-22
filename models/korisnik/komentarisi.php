<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['btnKomentarisi'])){
    $greske = [];
    $data = [];
    
    $komentarRoditelj = $_POST['komentarRod'];

    if(!isset($_POST['komentar']) || empty($_POST['komentar'])){
        array_push($greske, "Komentar ne sme da ostane prazan.");
    }
    if(!isset($_POST['vestId']) || !idVestiPostoji($_POST['vestId'])){
        array_push($greske, "Vest ne postoji.");
    }

    if(count($greske) == 0){
        $korisnik = $_SESSION['korisnik']->korisnik_id;
        $vestId = $_POST['vestId'];
        $komentar = $_POST['komentar'];
        $napisano = time();

        if($komentarRoditelj == ''){
            $upit = $connection->prepare("INSERT INTO komentari
            (komentar_id, vest_id, komentar_tekst, korisnik_id, komentar_napisan, komentar_rod)
            VALUES(null, :vest, :komentar, :kor, :napisano, null)");
            $upit->bindParam(':vest', $vestId);
            $upit->bindParam(':komentar', $komentar);
            $upit->bindParam(':kor', $korisnik);
            $upit->bindParam(':napisano', $napisano);
            $upit->execute();

            $data['brKomentara'] = ukupnoKomentara($vestId);
            $data['komentari'] = komentari($vestId);
            $data['poruka'] = "Komentar uspesno objavljen";

            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $upit = $connection->prepare("INSERT INTO komentari
            (komentar_id, vest_id, komentar_tekst, korisnik_id, komentar_napisan, komentar_rod)
            VALUES(null, :vest, :komentar, :kor, :napisano, :rod)");
            $upit->bindParam(':vest', $vestId);
            $upit->bindParam(':komentar', $komentar);
            $upit->bindParam(':kor', $korisnik);
            $upit->bindParam(':napisano', $napisano);
            $upit->bindParam(':rod', $komentarRoditelj);
            $upit->execute();

            $data['brKomentara'] = ukupnoKomentara($vestId);
            $data['komentari'] = komentari($vestId);
            $data['poruka'] = "Komentar uspesno objavljen";

            http_response_code(200);
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