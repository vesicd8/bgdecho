<?php
if(!isset($_SESSION['korisnik'])){

    header('location: 404.php');
    }
?>
<main>
    <div class="container d-flex justify-content-around p-5">
        <div class="col-xl-4 lg-4 md-4 sm-12">
            <div class="col-12">
                <span>Trenutna lozinka</span><input class="form-control mb-4" type="password" id="trenutna"/>
                <span>Nova lozinka</span><input class="form-control mb-4" type="password" id="nova"/>
                <span>Potvrdi lozinku</span><input class="form-control mb-4" type="password" id="potvrdi"/>
                <input class="form-control mt-5 mb-5 btn-dark pointer" type="button" value="Promeni lozinku" id="promeni"/>
            </div>
        </div>
    </div>
    <div class="container-fluid text-center" id="poruke"></div>
</main>