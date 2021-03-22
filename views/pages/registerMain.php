<?php        
    if(isset($_SESSION['korisnik'])){
        header('location: index.php');
    }
?>
<main>
    <div class="container-fluid">
        <div class="row d-flex justify-content-around p-5">
        <div class="col-12 mb-3 text-center"><h2>Registracija<h2></div>
        <div class="col-12 text-center">
        <div class="row">
        <div class="col-12">
            <div class="row">
                <div id="userMessage" class="col-6 mx-auto text-center text-danger p-2">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div id="aktivacioniLink" class="col-6 mx-auto text-center p-2">
                </div>
            </div>
        </div>
    </div>
        </div>
            <div class="col-xl-4 lg-4 md-4 sm-12 d-flex flex-column p-5">
                <input class="form-control m-2" type="text" id="ime-register" placeholder="Ime"/>
                <input class="form-control m-2" type="text" id="prezime-register" placeholder="Prezime"/>
                <input class="form-control m-2" type="text" id="korIme-register" placeholder="Korisnicko Ime"/>
                <input class="form-control m-2" type="email" id="email-register" placeholder="Email"/>
                <input class="form-control m-2" type="password" id="lozinka-register" placeholder="Lozinka"/>
                <input class="form-control m-2" type="password" id="lozinka-provera" placeholder="Unesite lozinku ponovo"/>
                <input type="button" class="form-control m-2 btn-dark" id="registrujKorisnika" value="Registruj se"/>
            </div>         
        </div>
    </div>
</main>