<?php
    ob_start();
    session_start();
    require_once 'setup/konekcija.php';
    require_once 'models/funkcije.php';
    require_once 'views/fixed/head.php';
    require_once 'views/fixed/header.php';
    require_once 'views/pages/admin-panel.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<?php
    require_once 'views/fixed/footer.php';
?>