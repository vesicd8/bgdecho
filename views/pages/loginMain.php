<?php
    if(isset($_SESSION['korisnik'])){
        header('location: index.php');
    }
?>
<main class="main">
<div class="container-fluid">
        <div class="row d-flex justify-content-around p-5">
            <div class="col-12 text-center"><h2>Ulogujte se<h2></div>
            <div class="col-xl-3 lg-4 sm-8 d-flex flex-column p-5">
                <form action="models/korisnik/logovanje.php" method="POST">
                    <input class="form-control m-2" type="text" name="korIme-login" placeholder="Korisnicko Ime"/>
                    <input class="form-control m-2" type="password" name="lozinka-login" placeholder="Lozinka"/>
                    <input type="submit" class="form-control btn-dark m-2 mt-5 pointer" name="ulogujKorisnika" value="Uloguj se"/>
                </form>
            </div>         
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-12 d-flex">
            <div class="col-6 mx-auto text-center">
                <?php
                    if(isset($_SESSION['greskeLogin'])){
                        echo '<p class="text-danger">'.$_SESSION['greskeLogin'].'</p>';
                        unset($_SESSION['greskeLogin']);
                    }
                    if(isset($_SESSION['nalogAktiviran'])){
                        echo '<p class="text-success">'.$_SESSION['nalogAktiviran'].'</p>';
                        unset($_SESSION['nalogAktiviran']);
                    }
                    if(isset($_SESSION['promenjenaLozinka'])){
                        echo '<p class="text-success">'.$_SESSION['promenjenaLozinka'].'</p>';
                        unset($_SESSION['promenjenaLozinka']);
                    }
                ?>
            </div>
        </div>
    </div>
</main>