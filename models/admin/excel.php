<?php
ob_start();
session_start();
require_once '../../setup/konekcija.php';
require_once '../funkcije.php';
header("Content-type: application/json");

if(isset($_POST['request'])){
    $src = $_SERVER['DOCUMENT_ROOT'] . "\bgdecho\data\korisnici.xls";
    if(file_exists($src)){
        unlink("C:\\xampp\htdocs\bgdecho\data\korisnici.xls");
    }
    $korisnici = korisnici();
    $excel = new COM('Excel.application') or die("Konekcija sa fajlom nije uspesna.");
    $workbook = $excel->Workbooks->Add();
    $worksheet = $workbook->Worksheets('Sheet1');  

    for($i = 0; $i < count($korisnici); $i++){
        $user = $korisnici[$i];
        $kor = array($user->korisnik_korisnicko_ime, $user->korisnik_prezime, $user->korisnik_ime, $user->korisnik_email, date('D, d. M. Y.', $user->korisnik_clan_od));
        for($j = "A", $k = 0; $j < "F";  $j++, $k++){
            $red = $i + 1;
            $polje = $worksheet->Range("$j$red");
            $polje->activate;
            $polje->Value = $kor[$k];
        }
    }
    
    $brojRedova = $worksheet->range('F1');
    $brojRedova->activate;
    $brojRedova->Value = count($korisnici);

    $workbook->SaveAs($src);
    $workbook->Save();
    $workbook->Saved = true;
    $workbook->Close;
    unset($workbook);
    $excel->Workbooks->Close();
    $excel->Quit();
    unset($excel);

    echo json_encode("Uspesno");
    http_response_code(200);
}
else{
    header("Location: ../../404.php");
}
    
    