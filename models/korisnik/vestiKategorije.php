<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['prikaziVesti'])){
    $data = [];
    if(!isset($_POST['katId']) || $_POST['katId'] == ''){
        http_response_code(400);
        echo json_encode('Kategorija nije izabrana');
    }
    else{
        $katId = $_POST['katId'];
        $vesti = vesti($katId);
        $vestiFullInfo = vestiKategorijaLimit(1, 5, $katId);

        foreach($vestiFullInfo as $vest){
            if(strlen($vest->vest_tekst) > 280){
                $tekst = substr($vest->vest_tekst, 0, 277).'...';
            }
            else{
                $tekst = $vest->vest_tekst;
            }
            $datum = date('D, d. M. Y.', $vest->vest_datum_objave);
            $vest->datum = mb_convert_encoding($datum, "UTF-8", "UTF-8");
            $vest->tekst = mb_convert_encoding($tekst, "UTF-8", "UTF-8");
        }

        $data['brojStranica'] = brojStranica($vesti, 5);
        $data['vesti'] = $vestiFullInfo;
        $data['katId'] = $katId;

        http_response_code(200);
        echo json_encode($data);
    }
}
else{
    header('location: ../../404.php'); 
}