<?php
    ob_start();
    session_start();
	require_once 'setup/konekcija.php';
	require_once 'models/funkcije.php';
    require_once 'views/fixed/head.php';
    require_once 'views/fixed/header.php';
    require_once 'views/pages/loginMain.php';
    require_once 'views/fixed/footer.php';
?>