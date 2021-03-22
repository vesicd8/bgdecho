<header class="container-fluid no-left-padding no-right-padding header_s header_s3">
	<div class="container-fluid no-left-padding no-right-padding menu-block">
		<div class="container">				
			<nav class="navbar ownavigation navbar-expand-lg">
						<a class="navbar-brand" href="index.php">echo</a>
						<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar3" aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fa fa-bars"></i>
						</button>
						<div class="collapse navbar-collapse" id="navbar3">
							<ul class="navbar-nav justify-content-end">
								<?php
									$navItems = navigacija();

									foreach($navItems as $navItem){
										$title = $navItem->title;
										$href = $navItem->href;
										$linkText = $navItem->link_tekst;

										echo "<li><a class='nav-link' title='$title' href='$href'>$linkText</a></li>";
									}
								?>
							</ul>
							<ul class="user-info">
							<li class="dropdown">
								<a class="dropdown-toggle" href="#"><i class="pe-7s-user"></i>
								<?php
									if(isset($_SESSION['korisnik'])){
										echo '<span id="user-name-text">'.$_SESSION['korisnik']->korisnik_korisnicko_ime.'</span>';
									}
								?>
								</a>
								<ul class="dropdown-menu">

								<?php

									if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->korisnik_uloga_id == 8){
										echo "
										<li><a class='dropdown-item' href='nalog.php' title='Vaš nalog'>Vaš nalog</a></li>
										<li><a class='dropdown-item' href='models/korisnik/logout.php' title='Izloguj se'>Izloguj se</a></li>";
									}
									else if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->korisnik_uloga_id == 5){
										echo "
										<li><a class='dropdown-item' href='dashboard.php' title='Nova vest'>Nova vest</a></li>
										<li><a class='dropdown-item' href='autorVesti.php' title='Uredi vest'>Uredi vest</a></li>
										<li><a class='dropdown-item' href='nalog.php' title='Vaš nalog'>Vaš nalog</a></li>
										<li><a class='dropdown-item' href='models/korisnik/logout.php' title='Izloguj se'>Izloguj se</a></li>";
									}
									else if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->korisnik_uloga_id == 1){
										echo "
										<li><a class='dropdown-item' href='admin.php' title='Admin panel'>Admin panel</a></li>
										<li><a class='dropdown-item' href='nalog.php' title='Vaš nalog'>Vaš nalog</a></li>
										<li><a class='dropdown-item' href='models/korisnik/logout.php' title='Izloguj se'>Izloguj se</a></li>";
									}
									else{
										echo "
										<li><a class='dropdown-item' href='login.php' title='Uloguj se'>Uloguj se</a></li>
										<li><a class='dropdown-item' href='register.php' title='Registruj se'>Registruj se</a></li>";
									}
								?>
								</ul>
							</li>
						</ul>
					</div>
			</nav>
		</div>
	</div>
</header>