<?php   
    if($_SESSION['korisnik']->korisnik_uloga_id != 5){
        header('location: 404.php');
    }
?>
<main>
    <div class="container d-flex justify-content-around p-5">
        <div class="col-xl-12 lg-4 md-4 sm-12 text-center">
            <h2 class="display-2">Nova vest</h2>
            <div class="col-12">
                <div class="container-fluid text-center" id="poruke">
                    <?php
                        if(isset($_SESSION['greske'])){
                            echo '<p class="text-danger">'.$_SESSION['greske'].'</p>';
                            unset($_SESSION['greske']);
                        }
                        if(isset($_SESSION['uspesno'])){
                            echo '<p class="text-success">'.$_SESSION['uspesno'].'</p>';
                            unset($_SESSION['uspesno']);
                        }
                        if(isset($_SESSION['greskeVest'])){
                            $greske = $_SESSION['greskeVest'];

                            foreach($greske as $greska){
                                echo '<p class="text-danger">'.$greska.'</p>';
                            }
                            
                            unset($_SESSION['greskeVest']);
                        }
                    ?>
                </div>
                <form action="models/urednik/kreirajvest.php" method="POST" enctype="multipart/form-data">
                    <input class="form-control m-2" type="text" placeholder="Naslov (obavezno)" name="naslov"/>
                    <span class="m-2 pt-2 pb-2 d-flex justify-content-between align-items-center"><input type="file" name="slika-sm"/> Preporučena rezolucija slike: 330x247</span>
                    <span class="m-2 pt-2 pb-2 d-flex justify-content-between align-items-center"><input type="file" name="slika-l"/> Preporučena rezolucija slike: 1164x500</span>
                    <span class="m-2 pt-2 pb-2 d-flex justify-content-between align-items-center"><input type="file" name="slika-xl"/> Preporučena rezolucija slike: 1170x605</span>
                    <input class="form-control m-2" type="text" placeholder="Opis slike/alt atribut (obavezno)" name="alt-attr"/>
                    <select class="form-control m-2" name="kategorija-vesti">
                        <?php
                            $obj = kategorije();
                            foreach($obj as $kat){
                                echo '<option value="' .$kat->kategorija_id.'">'.$kat->kategorija_naziv. '</option>';
                            }
                        ?>
                    </select>
                    <textarea class="form-control m-2" rows="30" placeholder="Unesite tekst vesti.." name="tekst-vesti"></textarea>
                    <input class="form-control m-2 pointer btn-dark" type="submit" name="kreiraj-vest" value="Kreiraj vest">
                </form>
            </div>
        </div>
    </div>    
</main>