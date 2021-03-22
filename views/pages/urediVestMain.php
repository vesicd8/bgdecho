<?php
    if($_SESSION['korisnik']->korisnik_uloga_id != 5){
        header('location: 404.php');
    }
    if(!isset($_GET['id'])){
        header('location: index.php');
    }
    if(!idVestiPostoji($_GET['id'])){
        header('location: 404.php');
    }
    $vestId = $_GET['id'];  
    $obj = vestInfo($vestId);
?>
    <div class="container-fluid ">
    <div class="row">
    <h2 class="mt-5 text-center mx-auto display-4">Uredi vest</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 text-center mx-auto">
                <?php
                    if(isset($_SESSION['izmeniSlikePoruka'])){
                        echo '<p class="text-success">'.$_SESSION['izmeniSlikePoruka'].'</p>';
                        unset($_SESSION['izmeniSlikePoruka']);
                    }
                    else if(isset($_SESSION['brojUloadovanihSlika'])){
                        echo '<p class="text-info">'.$_SESSION['brojUloadovanihSlika'].'</p>';
                        unset($_SESSION['brojUloadovanihSlika']);
                    }
                    if(isset($_SESSION['izmeniSlikeGreske'])){
                        $greske = $_SESSION['izmeniSlikeGreske'];

                        foreach($greske as $greska){
                            echo '<p class="text-danger">'.$greska.'</p>';
                        }
                        unset($_SESSION['izmeniSlikeGreske']);
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 text-center mx-auto">
                <?php
                    if(isset($_SESSION['izmeniVestPoruka'])){
                        echo '<p class="text-success">'.$_SESSION['izmeniVestPoruka'].'</p>';
                        unset($_SESSION['izmeniVestPoruka']);
                    }
                    else if(isset($_SESSION['izmeniVestGreska'])){
                        echo '<p class="text-danger">'.$_SESSION['izmeniVestGreska'].'</p>';
                        unset($_SESSION['izmeniVestGreska']);
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-12">
                <form action="models/urednik/izmenivest.php" method="POST">
                <input type="text" hidden name="idv" value="<?=$vestId?>"/>
                    <input class="form-control mb-3 mt-5" type="text" name="naslov" value='<?=$obj->vest_naslov?>'/>

                    <textarea class="form-control mb-3" name="tekst" cols="30" rows="20"><?=$obj->vest_tekst?></textarea>
                    <select class="form-control mb-3" name="kategorija-vesti">
                        <?php
                            $objKat = kategorije();

                            foreach($objKat as $kat){
                                if($obj->vest_kategorija_id == $kat->kategorija_id){
                                    echo '<option value="' .$kat->kategorija_id.'" selected="true">'.$kat->kategorija_naziv. '</option>';
                                }
                                else{
                                    echo '<option value="' .$kat->kategorija_id.'">'.$kat->kategorija_naziv. '</option>';
                                }
                            }
                        ?>
                    </select>
                    <input class="form-control mb-3" type="text" name="izmeniAlt" value='<?=$obj->slika_alt?>'/>
                    <input class="form-control pointer mb-3 btn-dark" name="izmeniVest" type="submit" value="Izmeni vest"/>
                </form>    
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex align-items-center text-center">
        <h2 class="mt-5 mb-5 mx-auto display-4">Izmeni slike</h2>
    </div>
    <div class="container-fluid">
        <div class="col-8 mx-auto">
            <form action="models/urednik/izmenivest.php" method="POST" enctype="multipart/form-data">
            <input type="text" hidden name="idv" value="<?=$vestId?>"/>
                <div class="col-12">
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 blog-paralle">
                        <div class="type-post">
                            <div class="entry-cover">
                                <img class="mb-3" src="assets/images/slikeVesti/<?=$obj->slika_sm?>" alt="SM<">
                                <span class="mx-auto">SM<input class="form-control" type="file" name="SM" id=""></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-8 col-lg-8 col-md-8 col-sm-8 blog-paralle">
                        <div class="type-post">
                            <div class="entry-cover">
                                <img class="mb-3" src="assets/images/slikeVesti/<?=$obj->slika_l?>" alt="L<">
                                <span>L<input class="form-control" type="file" name="L" id=""></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 blog-paralle">
                        <div class="type-post">
                            <div class="entry-cover">
                                <img class="mb-3" src="assets/images/slikeVesti/<?=$obj->slika_xl?>" alt="XL<">
                                <span>XL<input class="form-control" type="file" name="XL" id=""></span>
                            </div>
                        </div>
                    </div>
                </div>
                <input class="form-control mt-4 mb-4 btn-dark pointer" type="submit" name="izmeniSliku" value="Izmeni slike"/>
                <input class="form-control mb-4 pointer btn-danger pointer" data-vestId="<?=$vestId?>" type="button" value="Ukloni vest" id="btnObrisiVest">
            </form>
        </div>
    </div>