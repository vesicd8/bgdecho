<?php	
	if(!isset($_GET['vestId'])){
		header('location: index.php');
	}
	else if(vestInfo($_GET['vestId']) == null){
		header('location: 404.php');
	}
	else{
		$vest = $_GET['vestId'];
	
		$obj = vestInfo($vest);
	}
?>
<input type="hidden" id="idV" value="<?=$vest?>">
	<div class="main-container">
		<main class="site-main">
			<div class="container-fluid no-left-padding no-right-padding page-content blog-single post-nosidebar">
				<div class="container">
					<div class="entry-cover">
						<img src="assets/images/slikeVesti/<?=$obj->slika_xl?>" alt="<?=$obj->slika_alt?>" />
					</div>
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-12 content-area">
							<article class="type-post">
								<div class="entry-content">
									<div class="entry-header mb-5">	
										<span class="post-category"><?=$obj->kategorija_naziv?></span>
										<h3 class="entry-title"><?=$obj->vest_naslov?></h3>
										<div class="post-meta">											
											<span class="post-date mb-5"><?=date('d. M. Y.', $obj->vest_datum_objave)?></span>
										</div>
									</div>								
									<?=$obj->vest_tekst?>
								</div>
							</article>
							<div class="related-post">
								<h3>Pogledajte još</h3>
								<div class="related-post-block">
								<?php
								
								$povezaneVesti = preporuceneVesti($obj->vest_kategorija_id, $obj->vest_id);
								foreach($povezaneVesti as $vest){
									
									if(strlen($vest->vest_naslov) > 50){
										$tekst = substr($vest->vest_naslov, 0, 50);
									}
									else{
										$tekst = $vest->vest_naslov;
									}
									echo '<div class="related-post-box">
									<a href="vest.php?vestId='.$vest->vest_id.'"><img src="assets/images/slikeVesti/'.$vest->slika_sm.'" alt="'.$vest->slika_alt.'" /></a>
									<span><a href="vest.php?vestId='.$vest->vest_id.'" title="'.$vest->kategorija_naziv.'">'.$vest->kategorija_naziv.'</a></span>
									<h3><a href="vest.php?vestId='.$vest->vest_id.'" title="'.$tekst.'">'.$tekst.'</a></h3>
								</div>';
								}
								
								?>
								</div>
							</div>
							<div class="comments-area">
								<h2 class="comments-title" id="brKomentara"><?=ukupnoKomentara($_GET['vestId']);?> Komentara</h2>
								<ol class="comment-list" id="vest-komentari">
								<?php
									if(ukupnoKomentara($_GET['vestId']) > 0){
										$komentari = komentari($_GET['vestId']);
										echo $komentari;
									}
								?>
								</ol>
								<?php
								
									if(isset($_SESSION['korisnik'])):?>
										 	<div class="comment-respond">
												<h2 class="comment-reply-title">Ostavite komentar</h2>
												<div class="col-12 comment-form ml-3 mb-1" id="replyingTo"><span id="replyInfo">Odgovor na: vesicd8 </span><span><a id="reply-remove" href="#" title="Remove reply"><i class="fa fa-remove"></i></a></span> </div>
													<div class="col-12 comment-form">
														<p class="comment-form-comment">
															<textarea id="comment" name="comment" placeholder="Enter your comment here..." rows="8" required="required"></textarea>
														</p>
														<p class="form-submit">
															<input name="button" data-reply="" class="submit" id="btnKomentarisi" value="Komentarisi" type="submit"/>
														</p>
													</div>
												</div>
								<?php endif; ?>
							</div>
							<?php
								if(!isset($_SESSION['korisnik'])){
									echo '<p class="text-center">Morate se <a class="kategorije" href="login.php">ulogovati</a> kako biste komentarisali.</p>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>