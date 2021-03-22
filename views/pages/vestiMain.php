<div class="container-fluid no-left-padding no-right-padding menu-block border-bottom">
	<div class="container">				
		<nav class="navbar ownavigation navbar-expand-lg">
			<div class="collapse navbar-collapse" id="navbar3">
				<ul class="navbar-nav mx-auto kategorije">							
					<?php   
                        $rodKategorije = kategorijeRoditelji();

                        foreach($rodKategorije as $rodKategorija){
                            if(jeRoditelj($rodKategorija->kategorija_id)){
                                $katDeca = kategorijeDeca($rodKategorija->kategorija_id);

                                echo '  <li class="dropdown">
                                            <i class="ddl-switch fa fa-angle-down"></i>
                                            <a class="nav-link dropdown-toggle kategorije link-kat" data-kategorija="'.$rodKategorija->kategorija_id.'" title="'.$rodKategorija->kategorija_naziv.'" href="#">'.$rodKategorija->kategorija_naziv.'</a>
                                                <ul class="dropdown-menu">';
                                                foreach($katDeca as $katDete){
                                                    echo '<li class="text-center"><a class="dropdown-item kategorije link-kat" data-kategorija="'.$katDete->kategorija_id.'" href="#" title="'.$katDete->kategorija_naziv.'">'.$katDete->kategorija_naziv.'</a></li>';
                                                }

                                    echo '</ul></li>';

                            }
                            else{
                                    echo '<li><a class="nav-link kategorije link-kat" data-kategorija="'.$rodKategorija->kategorija_id.'" title="'.$rodKategorija->kategorija_naziv.'" href="vesti.php?kategorija='.$rodKategorija->kategorija_id.'">'.$rodKategorija->kategorija_naziv.'</a></li>';
                            }
                        }
                    ?>
				</ul>
			</div>
		</nav>
	</div>
</div>
<div class="container-fluid no-left-padding no-right-padding page-content blog-paralle-post-no-sidebar">
	<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-xl-10 col-lg-12 col-md-12 content-area mt-5">
					<div class="row mt-5" id="sveVesti">
                    <?php
                        $vestiPoStranici = 5;
                        $sveVesti = sveVestiLimit(1, $vestiPoStranici);

                        foreach($sveVesti as $vest){
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
                    ?>  
                    </div>
				</div>
			</div>
        </div>
    </div>
</div>
<nav class="navigation pagination">
	<div class="nav-links" id="stranice">
            <?php 
                $brojStranica = ceil(count(sveVesti())/$vestiPoStranici);
                    
                for($i = 1; $i <= $brojStranica; ++$i){

                    echo '<a class="page-numbers stranica" data-kategorija="" data-stranica="'.$i.'" href="#"><span class="meta-nav screen-reader-text">Stranica </span>'.$i.'</a>';

                }
            ?>
	</div>
</nav>