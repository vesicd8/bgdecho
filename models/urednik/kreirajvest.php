<?php
ob_start();
session_start();

require_once '../funkcije.php';

    if(isset($_POST['kreiraj-vest'])){

        $greske = [];

        $XL = proveriSliku($_FILES['slika-xl'], 'xl-', true);
        $L = proveriSliku($_FILES['slika-l'], 'l-', true);
        $SM = proveriSliku($_FILES['slika-sm'], 'sm-', true);

        if($SM != null && $L != null && $XL != null){


            if($_POST['naslov'] == ''){
                array_push($greske, "Naslov ne sme da bude prazan.");
            }
            if(strlen($_POST['naslov']) > 100){
                array_push($greske, "Maksimalna broj karatera za naslov je 100.");
            }
            if($_POST['tekst-vesti'] == ''){
                array_push($greske, "Morate uneti tekst vesti.");
            }
            if($_POST['kategorija-vesti'] == '' || !isset($_POST['kategorija-vesti'])){
                array_push($greske, "Morate uneti kategoriju.");
            }
            if($_POST['alt-attr'] == ''){
                array_push($greske, "Alt atribut je obavezan.");
            }

            if(count($greske) == 0){
                $slikaAlt = $_POST['alt-attr'];
                $naslov = $_POST['naslov'];
                $tekstVesti = $_POST['tekst-vesti'];
                $urednik = $_SESSION['korisnik']->korisnik_id;
                $kategorija = $_POST['kategorija-vesti'];
                $datumObjave = time();

                require_once '../../setup/konekcija.php';

                $upisVesti = $connection->prepare('INSERT INTO vesti (vest_id, urednik_id, vest_naslov, vest_tekst, vest_kategorija_id, vest_datum_objave, broj_pregleda)
                VALUES (NULL, :urednik, :naslov, :tekst, :kat, :datum, 0)');

                $upisVesti->bindParam(':urednik', $urednik);
                $upisVesti->bindParam(':naslov', $naslov);
                $upisVesti->bindParam(':tekst', $tekstVesti);
                $upisVesti->bindParam(':kat', $kategorija);
                $upisVesti->bindParam(':datum', $datumObjave);

                $rez = $upisVesti->execute();

                if($rez){
                    $idVesti = $connection->query('SELECT MAX(vest_id) as vestId FROM vesti');

                    $obj = $idVesti->fetch();

                    $idV = $obj->vestId;

                    $upisSlike = $connection->prepare('INSERT INTO slike (slike_id, vest_id, slika_alt, slika_xl, slika_l, slika_sm)
                    VALUES(NULL, :idV, :alt, :xl, :l, :sm)');
                    $upisSlike->bindParam(':idV', $idV);
                    $upisSlike->bindParam(':alt', $slikaAlt);
                    $upisSlike->bindParam(':xl', $XL);
                    $upisSlike->bindParam(':l', $L);
                    $upisSlike->bindParam(':sm', $SM);

                    $rezSlike = $upisSlike->execute();

                    if($rezSlike){
                        $_SESSION['uspesno'] = "Vest je uspesno objavljena.";
                        header('location: ../../dashboard.php');
                    }
                }
                else{
                    $_SESSION['greske'] = "Doslo je do greske pri objavljivanju vesti, molimo vas pokusajte kasnije.";
                    header('location: ../../dashboard.php');
                }

            }
            else{
                $_SESSION['greskeVest'] = $greske;
                header('location: ../../dashboard.php');
            }       

        }
        else{
            $_SESSION['greske'] = "Slike moraju biti formata jpg/jpeg ili png i moraju biti manje od 5 mb";
            header('location: ../../dashboard.php');
        }

}
else{
    header('location: ../../404.php');   
}