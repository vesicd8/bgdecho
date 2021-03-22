<?php

function promeniLozinku($nova, $stara, $kor){
    global $connection;

    $upit = $connection->prepare('UPDATE korisnik SET korisnik_lozinka = :nova 
    WHERE korisnik_korisnicko_ime = :kor AND korisnik_lozinka = :stara');

    $upit->bindParam(':nova', $nova);
    $upit->bindParam(':kor', $kor);
    $upit->bindParam(':stara', $stara);

    $rez = $upit->execute();

    return $rez;
}

function emailPostojiUBazi($mail){
    global $connection;

    $upit = $connection->prepare('SELECT korisnik_email FROM korisnik WHERE korisnik_email = :email');

    $upit->bindParam(':email', $mail);

    $rez = $upit->execute();

    if($rez){
        if($upit->rowCount() == 1){
            return true;
        }
        else{
            return false;
        }
    }
}

function resetujSesiju($korIme, $pass){
    global $connection;

    if(isset($_SESSION['korisnik'])){
        unset($_SESSION['korisnik']);
    }

    $sesija = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_korisnicko_ime = :kIme AND korisnik_lozinka = :lozinka');

    $sesija->bindParam(':kIme', $korIme);
    $sesija->bindParam(':lozinka', $pass);

    $sesija->execute();

    $obj = $sesija->fetch();

    $_SESSION['korisnik'] = $obj; 
}
function aktivacioniKod($username){
    global $connection;

    $upit = $connection->prepare('SELECT aktivacioni_kod FROM korisnik WHERE korisnik_korisnicko_ime = :korIme');
    $upit->bindParam(':korIme', $username);
    $upit->execute();
    $obj = $upit->fetch();
    return $obj->aktivacioni_kod;
}

function aktivirajNalog($aktKod){
    global $connection;

    $proveraNaloga = $connection->prepare('SELECT korisnik_status_id FROM korisnik WHERE aktivacioni_kod = :aktKod');

    $proveraNaloga->bindParam(':aktKod', $aktKod);

    $proveraRez = $proveraNaloga->execute();

    $id = $proveraNaloga->fetch();

    if($proveraNaloga->rowCount() == 1 && $id->korisnik_status_id != 1 ){

        $upit = $connection->prepare('UPDATE korisnik SET korisnik_status_id = 1 WHERE aktivacioni_kod = :kod');

        $upit->bindParam(':kod', $aktKod);

        $rez = $upit->execute();

        return $rez;
    }
    else{
        return false;
    }
}

function registruj($ime, $prezime, $korisnickoIme, $email, $loz){
    global $connection;

    $lozinkaZaUpis = md5($loz);
    $clanOd = time();
    $uloga = 8;
    $aktivan = 3;
    $kod = md5(sha1(time(). md5($email) . sha1($korisnickoIme)));

    $upit = $connection->prepare('INSERT INTO korisnik (korisnik_id, korisnik_ime, korisnik_prezime, korisnik_korisnicko_ime, korisnik_lozinka, korisnik_uloga_id, korisnik_email, korisnik_clan_od, korisnik_status_id, aktivacioni_kod)
    VALUES (NULL, :ime, :prezime, :korIme, :korLoz, :uloga, :korEmail, :korClanOd, :status, :kod)');

    $upit->bindParam(':ime', $ime);
    $upit->bindParam(':prezime', $prezime);
    $upit->bindParam(':korIme', $korisnickoIme);
    $upit->bindParam(':korLoz', $lozinkaZaUpis);
    $upit->bindParam(':uloga', $uloga);
    $upit->bindParam(':korEmail', $email);
    $upit->bindParam(':korClanOd', $clanOd);
    $upit->bindParam(':status', $aktivan);
    $upit->bindParam(':kod', $kod);

    $rez = $upit->execute();

    if($rez){
        return true;
    }
    else{
        return false;
    }
}

function korisnici(){
    global $connection;

    return $connection->query("SELECT * FROM korisnik")->fetchAll();
}

function upisi($imeSlike, $imeKolone, $id){ 
    global $connection;

    $upit = $connection->prepare("UPDATE slike SET $imeKolone = :vrednost WHERE vest_id = :vest");

    $upit->bindParam(':vrednost', $imeSlike);
    $upit->bindParam(':vest',  $id);

    $upit->execute();
}

function proveriSliku($slika, $prefiks, $prazno){
    $greskeUpload = [];

    $imeSlike = $slika['name'];
    $tmpName = $slika['tmp_name'];
    $tezinaSlike = $slika['size'];
    $tipFajla = $slika['type'];

    if($tipFajla != 'image/png' && $tipFajla != 'image/jpg' && $tipFajla != 'image/jpeg'){
        array_push($greskeUpload, "Tip fajla nije podrzan");
    }
    if($tezinaSlike > 5000000){
        array_push($greskeUpload, "Fajl ne sme biti veci od 5Mb-a.");
    }
    if(!$prazno){
        if($imeSlike == ''){
            array_push($greskeUpload, "Morate izabrati sliku.");
        }
    }
    if(count($greskeUpload) == 0){
        
        $ekstenzija = explode('.', $imeSlike);
        $ext = '.'.end($ekstenzija);

        $novoIme = $prefiks.time().md5(md5($imeSlike).sha1($imeSlike).time().sha1(time())).time().$ext;

        $lokacija = '../../assets/images/slikeVesti/'. $novoIme;

        $rez = move_uploaded_file($tmpName, $lokacija);

        if($rez){
            return $novoIme;
        }
        else{
            
            return null;
        }
    }
    else{
        $_SESSION['slikeUpload'] = $greskeUpload;
        return null;
    }
}

function kategorije(){
    global $connection;

    $kategorije = $connection->query('SELECT * FROM kategorije_vesti');
    $kategorije->execute();
    $obj = $kategorije->fetchAll();

    return $obj;
}

function kategorijeRoditelji(){
    global $connection;

    $kategorije = $connection->query('SELECT * FROM kategorije_vesti WHERE roditelj_id IS NULL');
    $kategorije->execute();
    $obj = $kategorije->fetchAll();

    return $obj;
}
function kategorijaInfo($katId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM kategorije_vesti WHERE kategorija_id = :kat');
    $upit->bindParam(':kat', $katId);
    $rez = $upit->execute();
    if($rez){
        if($upit->rowCount()==1){
            $obj = $upit->fetch();

            return $obj;
        }
        else{
            return null;
        }
    }
    else{
        return null;
    }
}

function idVestiPostoji($id){
    global $connection;

    $upit = $connection->prepare('SELECT vest_id FROM vesti WHERE vest_id = :id');

    $upit->bindParam(':id', $id);

    $upit->execute();

    $count = $upit->rowCount();

    if($count == 1){
        return true;
    }
    else{
        return false;
    }
}

function vestInfo($vestId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM vesti v INNER JOIN slike s ON s.vest_id = v.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id WHERE v.vest_id = :id');

    $upit->bindParam(':id', $vestId);

    $upit->execute();

    if($upit->rowCount() == 1) {
        $obj = $upit->fetch();

        return $obj;
    }
    else{
        return null;
    }

}

function uloge(){
    global $connection;
    $uloge = $connection->query('SELECT * FROM uloge')->fetchAll();
    return $uloge;
}

function novaAnketa($pitanje){
    global $connection;
    $akt = 0;

    deaktivirajSveAnkete();

    $novaAnketa = $connection->prepare('INSERT INTO anketa (anketa_id, pitanje, aktivna) VALUES (null, :pitanje, :akt)');

    $novaAnketa->bindParam(':pitanje', $pitanje);
    $novaAnketa->bindParam(':akt', $akt);

    $rez = $novaAnketa->execute();

    return $rez;
}

function deaktivirajSveAnkete(){
    global $connection;

    $neakt = 0;
    $deaktivirajSve = $connection->prepare('UPDATE anketa SET aktivna = :neakt');
    $deaktivirajSve->bindParam(':neakt', $neakt);
    $deaktivirajSve->execute();
}

function ankete(){
    global $connection;

    $upit = $connection->query('SELECT * FROM anketa');

    $obj = $upit->fetchAll();

    return $obj;

}
function anketeOdgovori($anketaId){
    global $connection;
    
    $upit = $connection->prepare('SELECT * FROM anketa_odgovori WHERE anketa_id = :ank');
    $upit->bindParam(':ank', $anketaId);
    $upit->execute();
    $obj = $upit->fetchAll();

    return $obj;
}
function dodajOdgovor($anketaId, $odgovor){
    global $connection;

    $upit = $connection->prepare('INSERT INTO anketa_odgovori (odgovor_id, anketa_id, odgovor) VALUES (null, :ank, :odg)');
    $upit->bindParam(':ank', $anketaId);
    $upit->bindParam(':odg', $odgovor);

    $rez = $upit->execute();

    return $rez;

}

function izmeniAnketu($ankId, $novoPitanje){
    global $connection;

    $upit = $connection->prepare('UPDATE anketa SET pitanje = :pitanje WHERE anketa_id = :id');

    $upit->bindParam(':pitanje', $novoPitanje);
    $upit->bindParam(':id', $ankId);

    $rez = $upit->execute();
    
    return $rez;
}

function odgovor($odgId){
    global $connection;

    $upit = $connection->prepare("SELECT * FROM anketa_odgovori WHERE odgovor_id = :id");
    $upit->bindParam(':id', $odgId);
    $upit->execute();

    if($upit->rowCount() == 1){
        $obj = $upit->fetch();

        return $obj;
    }
    else{
        return null;
    }
}

function aktivnaAnketa(){
    global $connection;
    $akt = 1;
    $upit = $connection->prepare('SELECT * FROM anketa WHERE aktivna = :akt');
    $upit->bindParam(':akt', $akt );
    $upit->execute();
    if($upit->rowCount() == 0){
        return null;
    }
    else{
        $obj = $upit->fetch();
        return $obj;
    }
}

// function aktivnaAnketa(){
//     global $connection;
//     $akt = 1;
//     $upit = $connection->prepare('SELECT * FROM anketa WHERE aktivna = :akt');
//     $upit->bindParam(':akt', $akt );
//     $upit->execute();
//     $obj = $upit->fetch();

//     return $obj;
// }

function jeBanovan($korId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_id = :id');
    $upit->bindParam(':id', $korId);
    $upit->execute();
    $obj = $upit->fetch();

    if($obj->korisnik_status_id == 2){
        return true;
    }
    else{
        return false;
    }
}
function banujKorisnika($korId){
    global $connection;
    $ban = 2;
    $upit = $connection->prepare('UPDATE korisnik SET korisnik_status_id = :stat WHERE korisnik_id = :korId');
    $upit->bindParam(':stat', $ban);
    $upit->bindParam(':korId', $korId);

    $rez = $upit->execute();

    return $rez;
}

function imaUlogu($korId, $ulogaId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM korisnik WHERE korisnik_id = :korId');
    $upit->bindParam(':korId', $korId);
    $upit->execute();

    $obj = $upit->fetch();
    if($obj->korisnik_uloga_id == $ulogaId){
        return true;
    }
    else{
        return false;
    }

}

function promeniUlogu($korId, $ulogaId){
    global $connection;

    $upit = $connection->prepare("UPDATE korisnik SET korisnik_uloga_id = :uloga WHERE korisnik_id = :korId");
    $upit->bindParam(':uloga', $ulogaId);
    $upit->bindParam(':korId', $korId);
    $rez = $upit->execute();

    return $rez;
}

function jeAktivna($anketaId){
    global $connection;

    $upit = $connection->prepare("SELECT * FROM anketa WHERE anketa_id = :id");
    $upit->bindParam(':id', $anketaId);
    $upit->execute();
    if($upit->rowCount() == 1 ){
        $obj = $upit->fetch();

        if($obj->aktivna == 1){
            return true;
        }
        else{
            return false;
        }
    }
}

function izmeniKategoriju($katId, $katIme, $rodId){
    global $connection;

    $upit = $connection->prepare('UPDATE kategorije_vesti SET kategorija_naziv = :katNaziv, roditelj_id = :rod WHERE kategorija_id = :katId');
    $upit->bindParam(':katNaziv', $katIme);
    $upit->bindParam(':rod', $rodId);
    $upit->bindParam(':katId', $katId);
    $rez = $upit->execute();

    return $rez;

}

function kategorijaPostoji($naziv){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM kategorije_vesti WHERE kategorija_naziv = :naziv');
    $upit->bindParam(':naziv', $naziv);
    $upit->execute();
    if($upit->rowCount() == 1){
        return true;
    }
    else{
        return false;
    }
}

function jeRoditelj($katId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM kategorije_vesti WHERE roditelj_id = :id');
    $upit->bindParam(':id', $katId);

    $upit->execute();

    if($upit->rowCount() != 0){
        return true;
    }
    else{
        return false;
    }
}

function kategorijeDeca($rodId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM kategorije_vesti WHERE roditelj_id = :id');
    $upit->bindParam(':id', $rodId);

    $upit->execute();

    $obj = $upit->fetchAll();

    return $obj;
}

function vesti($katId){
    global $connection;

    $vesti = $connection->prepare('SELECT * FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id WHERE kt.kategorija_id = :kat OR kt.roditelj_id = :kat ORDER BY v.vest_datum_objave DESC');

    $vesti->bindParam(':kat', $katId);

    $vesti->execute();

    $obj = $vesti->fetchAll();

    return $obj;
}

function stampajVesti($kategorija, $katNaziv){

    $str = '<div class="container-fluid no-left-padding no-right-padding page-content blog-paralle-post-no-sidebar">
    <div class="container">
        <div class="col-12 text-center"><h2 class="h1">'.$katNaziv.'</h2></div>
        <div class="row justify-content-md-center">
            <div class="col-xl-10 col-lg-12 col-md-12 content-area mt-5">
                <div class="row">';

    foreach($kategorija as $k){
        if(strlen($k->vest_tekst) > 280){
            $tekst = substr($k->vest_tekst, 0, 277).'...';
        }
        else{
            $tekst = $k->vest_tekst;
        }
        $datum = date('D, d. M. Y.', $k->vest_datum_objave);

        $str.= '<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
        <div class="type-post">
            <div class="entry-cover">
                <div class="post-meta">
                    <span class="post-date">'.$datum.'</span>
                </div>
                <a href="vest.php?id='.$k->vest_id.'"><img src="assets/images/slikeVesti/'.$k->slika_sm.'" alt="'.$k->slika_alt.'" /></a>
            </div>
            <div class="entry-content">
                <div class="entry-header">	
                    <span class="post-category">'.$k->kategorija_naziv.'</span>
                    <h3 class="entry-title"><a href="vest.php?vestId='.$k->vest_id.'" title="'.$k->vest_naslov.'">'.$k->vest_naslov.'</a></h3>
                </div>								
                <p>'.$tekst.'</p>
            </div>
        </div>
    </div>';
    }
    $str.='	</div></div></div></div></div>';
    return $str;
}

function sveVesti(){
    global $connection;

    $vesti = $connection->query('SELECT * FROM vesti v INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id ORDER BY v.vest_datum_objave DESC');

    $obj = $vesti->fetchAll();

    return $obj;    
}

function sveVestiLimit($limit, $vestiPoStranici){
    global $connection;

    $offset = ($limit - 1) * $vestiPoStranici;

    $vesti = $connection->query("SELECT * FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id ORDER BY v.vest_datum_objave DESC LIMIT $offset, $vestiPoStranici");

    $obj = $vesti->fetchAll();

    return $obj;    
}

function vestiKategorijaLimit($limit, $vestiPoStranici, $kategorijaId){
    global $connection;

    $offset = ($limit - 1) * $vestiPoStranici;

    $vesti = $connection->prepare("SELECT * FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id WHERE kt.kategorija_id = :kat OR kt.roditelj_id = :kat ORDER BY v.vest_datum_objave DESC LIMIT $offset, $vestiPoStranici");
    $vesti->bindParam(':kat', $kategorijaId);
    $vesti->execute();

    $obj = $vesti->fetchAll();

    return $obj;    
}

function najcitanijeVesti(){
    global $connection;
    $najcitanijeVesti = $connection->query('SELECT * FROM vesti v INNER JOIN kategorije_vesti kat ON v.vest_kategorija_id = kat.kategorija_id INNER JOIN slike s ON v.vest_id = s.vest_id ORDER BY v.broj_pregleda DESC LIMIT 0,5')->fetchAll();
    return $najcitanijeVesti;
}
function najnovijeVesti(){
    global $connection;

    $vesti = $connection->query("SELECT v.vest_id, v.vest_naslov, v.vest_tekst, v.vest_datum_objave, kt.kategorija_naziv, s.slika_sm, s.slika_alt FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id  ORDER BY v.vest_datum_objave DESC LIMIT 0, 3")->fetchAll();
    return $vesti;
}

function autorVesti($autorId){
    global $connection;

    $vesti = $connection->prepare('SELECT v.vest_id, v.vest_naslov, v.vest_tekst, v.vest_datum_objave, kt.kategorija_naziv, s.slika_xl, s.slika_alt FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id WHERE v.urednik_id = :id ORDER BY v.vest_datum_objave DESC');
    $vesti->bindParam(':id', $autorId);
    $vesti->execute();
    $obj = $vesti->fetchAll();

    return $obj;
}

function najcitanijeKategorije(){
    global $connection;

    $kategorije = $connection->query('SELECT SUM(v.broj_pregleda) AS brPregleda, kat.kategorija_naziv, v.vest_kategorija_id FROM vesti v INNER JOIN kategorije_vesti kat ON v.vest_kategorija_id = kat.kategorija_id GROUP BY kat.kategorija_naziv ORDER BY brPregleda DESC LIMIT 0,3')->fetchAll();

    return $kategorije;
}

function najcitanijeVestiKategorije($katId){
    global $connection;

    $najcitanijeVesti = $connection->prepare('SELECT * FROM vesti v INNER JOIN kategorije_vesti kat ON v.vest_kategorija_id = kat.kategorija_id INNER JOIN slike s ON v.vest_id = s.vest_id WHERE v.vest_kategorija_id = :kat ORDER BY v.broj_pregleda DESC LIMIT 0,5');
    $najcitanijeVesti->bindParam(':kat', $katId);
    $najcitanijeVesti->execute();
    $obj = $najcitanijeVesti->fetchAll();
    
    return $obj;
}

function preporuceneVesti($katId, $vestId){
    global $connection;

    $vesti = $connection->prepare('SELECT * FROM vesti v INNER JOIN korisnik k on v.urednik_id = k.korisnik_id INNER JOIN slike s on v.vest_id = s.vest_id INNER JOIN kategorije_vesti kt ON v.vest_kategorija_id = kt.kategorija_id WHERE (kt.kategorija_id = :kat OR kt.roditelj_id = :kat) AND v.vest_id <> :vest ORDER BY v.vest_datum_objave DESC');

    $vesti->bindParam(':kat', $katId);
    $vesti->bindParam(':vest', $vestId);
    $vesti->execute();

    $obj = $vesti->fetchAll();

    return $obj;
}

function brojStranica($brVesti, $vestiPoStranici){
    return ceil(count($brVesti)/$vestiPoStranici);
}

function komentariVestRod($vestId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM komentari k INNER JOIN korisnik kor ON k.korisnik_id = kor.korisnik_id WHERE k.vest_id = :id AND k.komentar_rod IS NULL');
    $upit->bindParam(':id', $vestId);
    $upit->execute();
    $obj = $upit->fetchAll();

    return $obj;
}

function komentariVestDeca($vestId, $komentarRod){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM komentari k INNER JOIN korisnik kor ON k.korisnik_id = kor.korisnik_id WHERE k.vest_id = :id AND k.komentar_rod = :rod');
    $upit->bindParam(':id', $vestId);
    $upit->bindParam(':rod', $komentarRod);
    $upit->execute();

    if($upit->rowCount() == 0){
        return null;
    }
    else{
        return $obj = $upit->fetchAll(); 
    }
}

function ukupnoKomentara($vestId){
    global $connection;

    $upit = $connection->prepare("SELECT COUNT(*) AS brKomentara FROM komentari WHERE vest_id = :id");
    $upit->bindParam(':id', $vestId);
    $upit->execute();
    $obj = $upit->fetch();

    return $obj->brKomentara;
}

function komentari($vestId){
        if(isset($_SESSION['korisnik'])){
            $korisnik = $_SESSION['korisnik'];
        }
        else{
            $korisnik = null;
        }
        $str = "";
        $komentariRod = komentariVestRod($vestId);
        foreach($komentariRod as $komentarRoditelj){
            if(komentariVestDeca($vestId, $komentarRoditelj->komentar_id) != null){
                if($korisnik != null && ($korisnik->korisnik_id == $komentarRoditelj->korisnik_id || $korisnik->korisnik_uloga_id == 1)){
                   $opcije =  '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Odgovori">Odgovori</a>
                   <a rel="nofollow" class="comment-remove-link" data-idzabrisanje="'.$komentarRoditelj->komentar_id.'" href="#" title="Ukloni odgovor">Ukloni</a>';
                }
                else{
                    $opcije = '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Reply">Reply</a>';
                }
                $komentariDeca =  komentariVestDeca($vestId, $komentarRoditelj->komentar_id);
                $str.= '<li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1 parent">
                <div class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <b class="fn">'.$komentarRoditelj->korisnik_korisnicko_ime.'</b>
                        </div>
                        <div class="comment-metadata">
                            <a href="#">'.date('d.m.Y H:i', $komentarRoditelj->komentar_napisan).'</a>											
                        </div>
                    </footer>
                    <div class="comment-content">
                        <p>'.$komentarRoditelj->komentar_tekst.'</p>
                    </div>
                    <div class="reply">
                        '.$opcije.'
                    </div>
                </div>
                <ol class="children">';
                foreach($komentariDeca as $komentar){
                    if($korisnik != null && ($korisnik->korisnik_id == $komentar->korisnik_id || $korisnik->korisnik_uloga_id == 1)){
                        $opcije =  '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Odgovori">Odgovori</a>
                        <a rel="nofollow" class="comment-remove-link" data-idzabrisanje="'.$komentar->komentar_id.'" href="#" title="Ukloni odgovor">Ukloni</a>';
                    }
                    else{
                         $opcije = '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Reply">Reply</a>';
                    }

                    $str.= '<li class="comment byuser comment-author-admin bypostauthor odd alt depth-2 parent">
                    <div class="comment-body">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <b class="fn">'.$komentar->korisnik_korisnicko_ime.'</b>
                            </div>
                            <div class="comment-metadata">
                                <a href="#">'.date('d.m.Y H:i', $komentar->komentar_napisan).'</a>											
                            </div>
                        </footer>
                        <div class="comment-content">
                            <p>'.$komentar->komentar_tekst.'</p>
                        </div>
                        <div class="reply">
                            '.$opcije.'
                        </div>
                    </div>
                </li>';
                }
                $str.= '</ol>';
            }
            else{
                if($korisnik != null && ($korisnik->korisnik_id == $komentarRoditelj->korisnik_id || $korisnik->korisnik_uloga_id == 1)){
                    $opcije =  '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Odgovori">Odgovori</a>
                    <a rel="nofollow" class="comment-remove-link" data-idzabrisanje="'.$komentarRoditelj->komentar_id.'" href="#" title="Ukloni odgovor">Ukloni</a>';
                }
                else{
                     $opcije = '<a rel="nofollow" class="comment-reply-link" data-username="'.$komentarRoditelj->korisnik_korisnicko_ime.'" data-komentarid="'.$komentarRoditelj->komentar_id.'" href="#comment" title="Reply">Reply</a>';
                }

                $str.= '<li class="comment byuser comment-author-admin bypostauthor even thread-odd thread-alt depth-1">
                <div class="comment-body">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <b class="fn">'.$komentarRoditelj->korisnik_korisnicko_ime.'</b>
                        </div>
                        <div class="comment-metadata">
                            <a href="#">'.date('d.m.Y H:i', $komentarRoditelj->komentar_napisan).'</a>											
                        </div>
                    </footer>
                    <div class="comment-content">
                        <p>'.$komentarRoditelj->komentar_tekst.'</p>
                    </div>
                    <div class="reply">
                        '.$opcije.'
                    </div>
                </div>
            </li>';
            }
        }

    return $str;
}

function navigacija(){
    global $connection;

    $upit = $connection->query('SELECT * FROM navigacija ORDER BY redosled');

    $upit->execute();
    return $menuItems = $upit->fetchAll();
}

function linkInformacije($linkId){
    global $connection;

    $upit = $connection->prepare('SELECT * FROM navigacija WHERE id = :id');
    $upit->bindParam(':id', $linkId);
    $upit->execute();

    return $upit->fetch();
}

function ukloniLink($linkId){
    global $connection;
    $upit = $connection->prepare('DELETE FROM navigacija WHERE id = :id');
    $upit->bindParam(':id', $linkId);
    $upit->execute();
}

function kreirajNoviLink($tekst, $href, $title, $prio){
    global $connection;

    $upit = $connection->prepare('INSERT INTO navigacija (id, href, link_tekst, title, redosled)
    VALUES (NULL, :href, :link, :title, :red)');
    $upit->bindParam(':href', $href);
    $upit->bindParam(':link', $tekst);
    $upit->bindParam(':title', $title);
    $upit->bindParam(':red', $prio);
    $upit->execute();
}

function izmeniLink($tekst, $href, $title, $prio, $id){
    global $connection;

    $upit = $connection->prepare('UPDATE navigacija SET href = :href, link_tekst = :link, title = :title, redosled = :red WHERE id = :id');
    $upit->bindParam(':href', $href);
    $upit->bindParam(':link', $tekst);
    $upit->bindParam(':title', $title);
    $upit->bindParam(':red', $prio);
    $upit->bindParam(':id', $id);
    $upit->execute();
}

function odradioAnketu($korId, $anketaId){
    global $connection;
    $upit = $connection->prepare('SELECT * FROM odradjena_anketa WHERE korisnik_id = :id AND anketa_id = :anketa');
    $upit->bindParam(':id', $korId);
    $upit->bindParam(':anketa', $anketaId);
    $upit->execute();
    
    if($upit->rowCount() == 0){
        return false;
    }
    else{
        return true;
    }
}

function odradiAnketu($korisnikId, $anketaId, $odgId){
    global $connection;

    $upit = $connection->prepare('INSERT INTO odradjena_anketa (id, anketa_id, korisnik_id, odgovor_id)
    VALUES (null, :ank, :id, :odg)');
    $upit->bindParam(':ank', $anketaId);
    $upit->bindParam(':id', $korisnikId);
    $upit->bindParam(':odg', $odgId);
    $upit->execute();
}