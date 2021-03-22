<?php
    if($_SESSION['korisnik']->korisnik_uloga_id != 1){
        header('location: 404.php');
    }
?>
<div class="container-fluid">
        <div class="row border border-bottom-dark p-5">
            <div class="col-12 mt-5 text-center">
                <h3 class="mb-5 display-4">Dodela uloge/banovanje korisnika</h3>
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex sekcija">
                    <div class="col-lg-6 md-12 item">
                        <input class="form-control" type="text" id="pretrazi" placeholder="Unesi korisničko ime"/>
                        <input class="form-control pointer mt-3 btn-dark" type="button" id="pretraziKorisnika" value="Pretraga"/>
                    </div>
                    <div class="col-lg-6 md-12">
                    <select class="form-control" disabled id="korisnici">
                    <option value="">Izaberi korisnika</option>
                    </select>
                    <div class="row p-3">
                        <div class="col-12 d-flex justify-content-around">
                            <input class="form-control btn-danger pointer" id="btnBanuj" disabled type="button" value="Banuj"/>
                            <select class="form-control ml-1 mr-1" id="uloga" disabled="true">
                            <option value="">Promeni ulogu</option>
                            <?php 
                            $ulogeRez = uloge();

                            foreach($ulogeRez as $uloga){
                                if($uloga->uloga_id != 1){
                                    echo '<option class="izaberiUlogu" value="'.$uloga->uloga_id.'">'.$uloga->uloga_naziv.'</option>';
                                }
                            }
                            ?>
                            </select>
                            <input class="form-control btn-success pointer" id="btnUloga" disabled type="button" value="Dodeli ulogu"/>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" id="update-excel">Azuriraj excel fajl sa svim korisnicima</a>
            <a href="#" id="update-excel">Azuriraj excel fajl sa svim korisnicima</a>
            <div class="col-12 m-3" id="greskePretraga"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
            <h3 class="mb-5 display-4">Anketa</h3>
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex sekcija">
                    <div class="col-lg-6 md-12 item">
                    <div class="container-fluid">
                            <h3>Upravljanje anketama: </h3>
                        </div>
                        <select class="form-control mb-3" id="upravljanjeAnketamaDdl">
                        <option value="">Izaberite anketu</option>
                        <?php
                            $ankete = ankete();

                            foreach($ankete as $anketa){
                                if($anketa->aktivna == 1){
                                    echo '<option selected value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                                else{
                                    echo '<option value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                            }
                        ?>
                        </select>
                        <div class="container-fluid d-flex justify-content-around">
                            <input class="form-control btn-light pointer" type="button" value="Aktiviraj" id="btnAktivirajAnketu"/>
                            <input class="form-control btn-secondary pointer ml-1 mr-1" type="button" value="Ukloni" id="btnUkloniAnketu"/>
                            <input class="form-control btn-dark pointer" type="button" value="Deaktiviraj sve ankete" id="btnDeaktivirajSveAnkete"/>
                        </div>
                        <div class="col-12 mt-3" id="upravljajAnketamaPoruke"></div>
                    </div>
                    <div class="col-lg-6 md-12 mb-3">
                        <div class="container-fluid">
                            <h3>Statistika: </h3>
                        </div>
                        <canvas class="pointer" id="myChart">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex sekcija">
                    <div class="col-lg-6 md-12 item">
                    <div class="container-fluid">
                            <h3>Kreiraj anketu: </h3>
                        </div>
                        <input class="form-control mb-3" type="text" id="novaAnketa" placeholder="Unesi pitanje"/>
                        <input class="form-control mb-3 btn-dark pointer" type="button" id="btnKreirajAnketu" value="Kreiraj anketu"/>
                        <div class="col-12" id="kreirajAnketuPoruke"></div>
                    </div>
                    <div class="col-lg-6 md-12">
                        <div class="container-fluid">
                            <h3>Dodaj odgovor na izabranu anketu: </h3>
                        </div>
                        <select class="form-control mb-3" id="ankete">
                        <option value="">Izaberi anketu</option>
                        <?php
                            $aktivna = null;
                            foreach($ankete as $anketa){
                                if($anketa->aktivna == 1){
                                    $aktivna = $anketa;
                                    echo '<option selected value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                                else{
                                    echo '<option value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                            }
                        ?>
                        </select>
                        <input class="form-control mb-3" type="text" id="dodajOdgovor" placeholder="Unesi odgovor"/>
                        <input class="form-control mb-3 btn-dark pointer" type="button" id="btnDodajOdgovor" value="Dodaj odgovor na izabranu anketu"/>
                        <div class="col-12" id="dodajOdgPoruke"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row border-bottom-dark p-5">
            <div class="col-12 mt-5 text-center">
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex sekcija">
                    <div class="col-lg-6 md-12 item">
                    <div class="container-fluid">
                            <h3>Izmeni pitanje: </h3>
                        </div>
                        <select class="form-control mb-3" id="izmeniPitanjeDdl">
                        <option value="">Izaberi anketu</option>
                        <?php

                            if(count($ankete) != 0){
                                foreach($ankete as $anketa){
                                    if($anketa->aktivna == 1){
                                        echo '<option selected value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                    }
                                }
                            }

                        ?>
                        </select>
                        <input class="form-control mb-3" type="text" placeholder="Izmeni anketu" id="tbIzmeniPitanje" value="<?php
                        
                        if($aktivna != null){
                            echo $aktivna->pitanje;
                        }
                        
                        ?>"/>
                        <input class="form-control mb-3 btn-dark pointer" type="button" id="btnIzmeniAnketu" value="Izmeni anketu"/>
                        <div class="col-12" id="izmeniPitanjePoruke"></div>
                    </div>
                    <div class="col-lg-6 md-12 mb-3">
                        <div class="container-fluid">
                            <h3>Izmeni odgovore: </h3>
                        </div>
                        <select class="form-control mb-3" id="izmeniOdgovoreDdl">
                        <option value="">Izaberi anketu</option>
                        <?php

                            foreach($ankete as $anketa){
                                if($anketa->aktivna == 1){
                                    echo '<option selected value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                                else{
                                    echo '<option value="'.$anketa->anketa_id.'">'.$anketa->pitanje.'</option>';
                                }
                            }
                        ?>
                        </select>
                        <select class="form-control mb-3" id="odgovoriDdl">
                        <option selected value="">Izaberi odgovor</option>
                        <?php
                        if($aktivna != null){
                            $odgovori = anketeOdgovori($aktivna->anketa_id);
                            if($odgovori != null){
                                foreach($odgovori as $odgovor){
                                    echo '<option selected value="'.$odgovor->odgovor_id.'">'.$odgovor->odgovor.'</option>';
                                }
                            }
                        }

                        ?>
                        </select>
                        <input class="form-control mb-3" type="text" id="noviOdgovor" placeholder="Izmeni dati odgovor"/>
                        <input class="form-control mb-3 btn-dark pointer" type="button" id="btnIzmeniOdgovor" value="Izmeni izabrani odgovor"/>
                        <div class="col-12" id="izmeniOdgovorPoruke"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
            <h3 class="mb-5 display-4">Kategorije vesti</h3>
                <div class="col-lg-8 md-12 mx-auto mb-2 d-flex sekcija">
                    <div class="col-lg-6 md-12 item">
                    <div class="container-fluid">
                            <h3>Upravljanje kategorijama: </h3>
                        </div>
                        <select class="form-control mb-3" id="upravljanjeKategorijamaDdl">
                        <option value="">Izaberite kategoriju</option>
                        <?php
                            $kategorije = kategorije();

                            foreach($kategorije as $kategorija){
                                if($kategorija->roditelj_id != null){
                                    $rod = $kategorija->roditelj_id;
                                }
                                else{
                                    $rod = "";
                                }
                                echo '<option data-rod="'.$rod.'"value="'.$kategorija->kategorija_id.'">'.$kategorija->kategorija_naziv.'</option>';
                            }
                        ?>
                        </select>
                            <input class="form-control btn-dark pointer" type="button" value="Ukloni kategoriju" id="btnUkloniKategoriju"/>
                            <div class="container-fluid mt-3" id="kategorijePoruke"></div>
                        <div class="col-12 mt-3" id="upravljajKategorijamaPoruke"></div>
                    </div>
                    <div class="col-lg-6 md-12 mb-5">
                        <div class="container-fluid">
                            <h3>Podešavanja kategorije: </h3>
                        </div>
                        <div class="container-fluid">
                        <input class="form-control mb-3" type="text" id="novoImeKat" placeholder="Novo ime kategorije"/>
                        <select class="form-control mb-3" id="upravljanjeRodKategorijamaDdl">
                        <option value="">Izaberi roditeljsku kategoriju</option>
                        <?php
                            $rodKat = kategorijeRoditelji();

                            foreach($rodKat as $kategorija){
                                echo '<option class="rodKategorija" value="'.$kategorija->kategorija_id.'">'.$kategorija->kategorija_naziv.'</option>';
                            }
                        ?>
                        </select>
                        <input class="form-control btn-dark pointer" type="button" value="Izmeni kategoriju" id="btnIzmeniKategoriju"/>
                        <div class="col-12 mt-3" id="izmeniKatPoruke"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex">
                    <div class="col-lg-6 md-8 xs-12">
                    <div class="container-fluid">
                            <h3>Kreiraj kategoriju: </h3>
                        </div>
                            <input class="form-control mb-3" type="text" id="tbNovaKat" placeholder="Unesi ime nove kategorije"/>
                            <select class="form-control mb-3" id="novaKatRodDdl">
                            <option value="">Nema roditelja</option>
                            <?php
                                foreach($rodKat as $kategorija){
                                    echo '<option class="rodKategorija" value="'.$kategorija->kategorija_id.'">'.$kategorija->kategorija_naziv.'</option>';
                                }
                            ?>
                            </select>
                            <input class="form-control btn-dark pointer" type="button" value="Kreiraj novu kategoriju" id="btnKreirajNovuKat"/>
                            <div class="container-fluid mt-3" id="kreirajKategorijuPoruke"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
            <h3 class="mb-5 display-4">Navigacija</h3>
            <div class="col-12 text-center" id="navigacijaPoruke"></div>
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex">
                    <div class="col-lg-6 md-12">
                        <div class="col-12" id="navigacijaPoruke"></div>
                        <select class="form-control mb-3" id="upravljanjeLinkovima">
                        <option value="">Izaberite link: </option>
                        <?php
                            $navItems = navigacija();

                            foreach($navItems as $navItem){
                                $title = $navItem->title;
                                $href = $navItem->href;
                                $linkText = $navItem->link_tekst;
                                $id = $navItem->id;
                                echo '<option value="'.$id.'">'.$linkText.' - '.$href.'</option>';
                            }
                        ?>
                        </select>
                        <div id="podesavanjaLinka">
                            <input class="form-control mb-3" type="text" id="tbLinkTekst" placeholder="Tekst linka"/>
                            <input class="form-control mb-3" type="text" id="tbHref" placeholder="Href"/>
                            <input class="form-control mb-3" type="text" id="tbTitle" placeholder="Link title"/>
                            <input class="form-control mb-3" type="number" placeholder="Prioritet" id="prioritet"/>
                            <input class="form-control btn-success mb-3 pointer" id="btnSacuvajIzmeneLink" type="button" value="Sačuvaj izmene"/>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-5">
                        <div class="container-fluid">
                        <input class="form-control btn-primary mb-3 pointer" id="btnIzmeniLink" type="button" value="Izmeni link"/>
                        <input class="form-control btn-danger  mb-3 pointer" id="btnUkloniLink" type="button" value="Obriši link"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-12 mt-5 text-center">
                <div class="col-lg-8 md-12 mx-auto mb-5 d-flex">
                    <div class="col-lg-6 md-12">
                    <div class="container-fluid">
                            <h3>Kreiraj link: </h3>
                        </div>
                            <input class="form-control mb-3" type="text" id="tbNoviLinkTekst" placeholder="Unesi ime linka"/>
                            <input class="form-control mb-3" type="text" id="tbLinkHref" placeholder="Unesi putanju ovog linka"/>
                            <input class="form-control mb-3" type="text" id="tbLinkTitle" placeholder="Unesi title (opciono)"/>
                            <input class="form-control mb-3" type="number" placeholder="Prioritet" id="numPrioritet"/>
                            <input class="form-control btn-dark pointer" type="button" value="Kreiraj novi link" id="btnKreirajNoviLink"/>
                            <div class="container-fluid mt-3" id="kreirajKategorijuPoruke"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    