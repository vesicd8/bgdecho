<div class="container-fluid">
        <div class="row m-5">
            <div class="col-8 mx-auto">
                <div class="container-fluid text-center mb-5">
                    <h2>Izaberite vest</h2>
                </div>
                    <div class="col-12" id="obrisiVestPoruke">
                    </div>
    <?php
    if($_SESSION['korisnik']->korisnik_uloga_id == 5){
        $id = $_SESSION['korisnik']->korisnik_id;
    }
    else{
        header('location: 404.php');
    }
    $obj = autorVesti($id);
    foreach($obj as $o){
        if(strlen($o->vest_tekst) > 350){
            $tekst = substr($o->vest_tekst, 0, 347).'...';
        }
        else{
            $tekst = $o->vest_tekst;
        }
        $datum = date('D, d. M. Y.', $o->vest_datum_objave);

        echo '<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
        <div class="type-post">
            <div class="entry-cover">
                <div class="post-meta">
                    <span class="post-date">'.$datum.'</span>
                </div>
                <a href="urediVest.php?id='.$o->vest_id.'"><img src="assets/images/slikeVesti/'.$o->slika_xl.'" alt="'.$o->slika_alt.'" /></a>
            </div>
            <div class="entry-content">
                <div class="entry-header">	
                    <span class="post-category">'.$o->kategorija_naziv.'</span>
                    <h3 class="entry-title"><a href="urediVest.php?id='.$o->vest_id.'" title="'.$o->vest_naslov.'">'.$o->vest_naslov.'</a></h3>
                </div>								
                <p>'.$tekst.'</p>
            </div>
        </div>
    </div>';
    }
    ?>
            </div>
        </div>
    </div>