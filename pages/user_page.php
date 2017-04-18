<?php
namespace area_riservata;
//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/
$viewU = new FileView();

$user = wp_get_current_user();

?>
<a class="float-right" href="<?php echo wp_logout_url(curPageURL() )?>">
    <span class="back-text">LOGOUT</span>
</a>
<div class="container-user">
    <h2>Area Riservata</h2>
    
    <?php $viewU->printTabellaFiles($user->ID) ?>
</div>
