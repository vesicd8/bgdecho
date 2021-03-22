<div class="main-container">
		<main class="site-main">
			<div class="container-fluid no-left-padding no-right-padding slider-section slider-section7">				
				<div class="slider-carousel slider-carousel-7 center">
				<?php					
					$najcitanije = najcitanijeVesti();

					foreach($najcitanije as $vest){
                        echo '
                        <div class="item">
                            <div class="post-box">
                                <img class="img-responsive" src="assets/images/slikeVesti/'.$vest->slika_l.'" alt="'.$vest->slika_alt.'" />
                                <div class="entry-content">
                                    <span class="post-category white">'.$vest->kategorija_naziv.'</span>
                                    <h3><a href="vest.php?vestId='.$vest->vest_id.'" title="'.$vest->vest_naslov.'">'.$vest->vest_naslov.'</a></h3>
                                    <a href="vest.php?vestId='.$vest->vest_id.'" title="Saznaj vise">Saznaj vise</a>
                                </div>
                            </div>
					    </div>';
					}
				?>
		</div>
    </div>
    <?php
        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->korisnik_uloga_id == 8):?>
<div class="mx-auto col-8 border p-5 d-flex flex-column align-items-center anketaPozicija" id="anketa">
    <div class="col-12 d-flex justify-content-end"><a id="reply-remove" href="#"><i class="fa fa-remove"></i></a></div>
    <p>S obzirom da smo tek počeli sa radom, jako bi nam značilo kada biste izdvojili malo vremena i odradili kratku anketu.</p>
    <div id="anketaPitanje"></div>
        <div class="col-3">
            <input class="btn-dark mt-3 form-control pointer" data-anketaid="" id="btnOdradiAnketu" type="button" value="Odgovori"/>
            <div id="anketaPor"></div>
        </div>
</div>
        <?php endif;?>
    <div class="container-fluid no-left-padding no-right-padding page-content blog-paralle-post-no-sidebar">
	<div class="container">
		<div class="col-12 text-center mt-5 mb-5"><h2 class="display-4">Najnovije vesti</h2></div>
			<div class="row justify-content-md-center">
				<div class="col-xl-10 col-lg-12 col-md-12 content-area mt-5">
					<div class="row mt-5">
					<?php
                        $vestiobj = najnovijeVesti();

                        foreach($vestiobj as $o){
                            if(strlen($o->vest_tekst) > 280){
                                $tekst = substr($o->vest_tekst, 0, 277).'...';
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
                                    <a href="vest.php?vestId='.$o->vest_id.'"><img src="assets/images/slikeVesti/'.$o->slika_sm.'" alt="'.$o->slika_alt.'" /></a>
                                </div>
                                <div class="entry-content">
                                    <div class="entry-header">	
                                        <span class="post-category">'.$o->kategorija_naziv.'</span>
                                        <h3 class="entry-title"><a href="vest.php?vestId='.$o->vest_id.'" title="'.$o->vest_naslov.'">'.$o->vest_naslov.'</a></h3>
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
				</div>
			</div>
		</main>
	</div>
    <div class="container-fluid no-left-padding no-right-padding page-content blog-paralle-post-no-sidebar">
	<div class="container">
		<div class="col-12 text-center"><h2 class="display-4">Najčitanije vesti</h2></div>
			<div class="row justify-content-md-center">
				<div class="col-xl-10 col-lg-12 col-md-12 content-area mt-5">
					<div class="row mt-5">
                        <?php
                            $najcitanijeVesti = najcitanijeVesti();

                            foreach($najcitanijeVesti as $najcitanijaVest){
                                if(strlen($najcitanijaVest->vest_tekst) > 280){
                                    $tekst = substr($najcitanijaVest->vest_tekst, 0, 277).'...';
                                }
                                else{
                                    $tekst = $najcitanijaVest->vest_tekst;
                                }
                                $datum = date('D, d. M. Y.', $najcitanijaVest->vest_datum_objave);
                                echo '<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
                                <div class="type-post">
                                    <div class="entry-cover">
                                        <div class="post-meta">
                                            <span class="post-date">'.$datum.'</span>
                                        </div>
                                        <a href="vest.php?vestId='.$najcitanijaVest->vest_id.'"><img src="assets/images/slikeVesti/'.$najcitanijaVest->slika_sm.'" alt="'.$najcitanijaVest->slika_alt.'" /></a>
                                    </div>
                                    <div class="entry-content">
                                        <div class="entry-header">	
                                            <span class="post-category">'.$najcitanijaVest->kategorija_naziv.'</span>
                                            <h3 class="entry-title"><a href="vest.php?vestId='.$najcitanijaVest->vest_id.'" title="'.$najcitanijaVest->vest_naslov.'">'.$najcitanijaVest->vest_naslov.'</a></h3>
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
        </div>
    </div>
</div>
<div class="col-12 text-center"><h2 class="display-4">Popularno medju kategorijama</h2></div>
<?php
    $najcitanijeKat = najcitanijeKategorije();

    foreach($najcitanijeKat as $kat){
        echo '<div class="container-fluid no-left-padding no-right-padding page-content blog-paralle-post-no-sidebar">
        <div class="container">
            <div class="col-12 text-center"><h2>'.$kat->kategorija_naziv.'</h2></div>
                <div class="row justify-content-md-center">
                    <div class="col-xl-10 col-lg-12 col-md-12 content-area">
                        <div class="row mt-5">';
                        $vesti = najcitanijeVestiKategorije($kat->vest_kategorija_id);

                        foreach($vesti as $vest){
                            if(strlen($vest->vest_tekst) > 280){
                                $tekst = substr($vest->vest_tekst, 0, 277).'...';
                            }
                            else{
                                $tekst = $vest->vest_tekst;
                            }
                            $datum = date('D, d. M. Y.', $vest->vest_datum_objave);
                            echo '<div class="col-12 col-lg-12 col-md-6 col-sm-6 blog-paralle">
                            <div class="type-post">
                                <div class="entry-cover">
                                    <div class="post-meta">
                                        <span class="post-date">'.$datum.'</span>
                                    </div>
                                    <a href="vest.php?vestId='.$vest->vest_id.'"><img src="assets/images/slikeVesti/'.$vest->slika_sm.'" alt="'.$vest->slika_alt.'" /></a>
                                </div>
                                <div class="entry-content">
                                    <div class="entry-header">	
                                        <span class="post-category">'.$vest->kategorija_naziv.'</span>
                                        <h3 class="entry-title"><a href="vest.php?vestId='.$vest->vest_id.'" title="'.$vest->vest_naslov.'">'.$vest->vest_naslov.'</a></h3>
                                    </div>								
                                    <p>'.$tekst.'</p>
                                </div>
                            </div>
                        </div>';
                        }

        echo '                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }
?>