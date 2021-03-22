<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['aktivnaAnketa'])){

    $aktivna = aktivnaAnketa();

    $aktAnketaId = $aktivna->anketa_id;

    $odgovori = anketeOdgovori($aktAnketaId);

    foreach($odgovori as $odgovor){
        $odgId = $odgovor->odgovor_id;
        $upit = $connection->prepare("SELECT COUNT(*) AS glasovi FROM odradjena_anketa WHERE odgovor_id = :id");
        $upit->bindParam(':id', $odgId);
        $upit->execute();
        $obj = $upit->fetch();

        $odgovor->brojGlasova = $obj->glasovi;
        
    }

    $labels = [];
    $glasovi = [];

    foreach($odgovori as $odg){
        array_push($labels, $odg->odgovor);
        array_push($glasovi, $odg->brojGlasova);
    }
    
    $data['nizGlasova'] = $glasovi;
    $data['nizOdgovora'] = $labels;

    echo json_encode($data);

}
else{
    header('location: ../../404.php');
}