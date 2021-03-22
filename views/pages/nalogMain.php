<?php
    if(!isset($_SESSION['korisnik'])){

    header('location: 404.php');
    }
?>
<main>
<div class="container d-flex justify-content-around p-5">
<div class="col-xl-4 lg-4 md-4 sm-12">
    <div class="col-12">
        <span>Ime</span><input class="form-control mb-4" type="text" id="ime" value="<?=$_SESSION['korisnik']->korisnik_ime?>"/>
        <span>Prezime</span><input class="form-control mb-4" type="text" id="prezime" value="<?=$_SESSION['korisnik']->korisnik_prezime?>"/>
        <span>Email</span><input class="form-control mb-4" type="email" id="email" value="<?=$_SESSION['korisnik']->korisnik_email?>"/>
        <span>Potvrdi lozinku</span><input class="form-control mb-4" type="password" id="pass"/>
        <input class="form-control mt-5 mb-5 btn-dark pointer" type="button" value="Izmeni" id="izmeni"/>
        <div class="container-fluid text-center">
            <a class="kategorije" href="promenalozinke.php">Promeni lozinku</a>
        </div>
    </div>
</div>
</div>
<div class="container-fluid text-center" id="poruke"></div>
</main>