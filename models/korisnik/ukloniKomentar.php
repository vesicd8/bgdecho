<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['obrisiKomentar'])){
    if(!isset($_POST['komentar'])){
        http_response_code(400);
        echo json_encode("Komentar nije izabran");
    }
    else{
        $komentar = $_POST['komentar'];
        $vestId = $_POST['vestId'];

        if(komentariVestDeca($vestId, $komentar) != null){
            $upit = $connection->prepare('DELETE FROM komentari WHERE komentar_id = :id OR komentar_rod = :id');
            $upit->bindParam(':id', $komentar);
            $upit->execute();
            
            $data['brKomentara'] = ukupnoKomentara($vestId);
            $data['komentari'] = komentari($vestId);
            $data['poruka'] = "Komentar sa svim odgovorima je obrisan.";
    
            http_response_code(200);
            echo json_encode($data);
        }
        else{
            $upit = $connection->prepare('DELETE FROM komentari WHERE komentar_id = :id');
            $upit->bindParam(':id', $komentar);
            $upit->execute();
            
            $data['brKomentara'] = ukupnoKomentara($vestId);
            $data['komentari'] = komentari($vestId);
            $data['poruka'] = "Komentar obrisan.";

            http_response_code(200);
            echo json_encode($data);
        }
    }
}
else{
    header('location: ../../404.php');
}