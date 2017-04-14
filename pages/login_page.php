<?php

namespace area_riservata;

if(is_user_logged_in()){
    $user = wp_get_current_user();
    if($user->has_cap('administrator')){
        include 'admin_page.php';
    }
    else if($user->has_cap('editor')){
        include 'admin_page.php';
    }
    else if($user->has_cap('subscriber')){
        include 'user_page.php';
    }
}
else{
   wp_login_form();
}
?>


