<?php
ob_start();
session_start();
header('Content-type: application/json');
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';

if(isset($_POST['novaStranica'])){

    $stranica = $_POST['limit'];

    if($_POST['kategorija'] == ''){

        $vesti = sveVestiLimit($stranica, 5);
        
        foreach($vesti as $vest){
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

        http_response_code(200);
        echo json_encode($vesti);
        
    }
    else{
        $vesti = vestiKategorijaLimit($stranica, 5, $_POST['kategorija']);
        
        foreach($vesti as $vest){
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
        http_response_code(200);
        echo json_encode($vesti);
    }
}
