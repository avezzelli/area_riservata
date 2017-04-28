<?php

//Autore: Alex Vezzelli - Seo siti marketing
//url: http://www.alexsoluzioniweb.it/
 /**
 * @package area_riservata
 */
/*
Plugin Name: Area Riservata
Plugin URI: 
Description: Plugin che genera un'area riservata personalizzata
Version: 1.0
Author: Alex Vezzelli - Seo Siti Marketing
Author URI: https://www.seositimarketing.it
License: GPLv2 or later
*/

//includo le librerie
require_once 'assets/variabili_globali.php';
require_once 'assets/api_db.php';
require_once 'assets/classes.php';
require_once 'assets/functions.php';

//indico la cartella dove è contenuto il plugin
require_once (dirname(__FILE__) . '/area_riservata.php');

//creo il db al momento dell'attivazione
register_activation_hook(__FILE__, 'install_area_riservata');
function install_area_riservata(){
    //installo il db
    area_riservata\install_AreaRiservata();
    //creo la pagina
    area_riservata\create_admin_pages();
}


//rimovo il db quando disattivo il plugin
register_deactivation_hook(__FILE__, 'remove_area_riservata');
function remove_area_riservata(){
    //rimuovo il database
    area_riservata\drop_AreaRiservata();
    //rimuovo la pagina
    area_riservata\delete_admin_page();
}



//SHORTCODE
add_shortcode('AreaRiservata', 'add_area_riservata');


function add_area_riservata(){
    include 'pages/login_page.php';
}

//CSS PUBLIC
function register_ar_styles(){
    wp_register_style('ar_style_css', plugins_url('css/style.css', __FILE__));
    wp_register_style('ar_bootstrap-style', plugins_url('css/bootstrap.min.css', __FILE__) );
    wp_register_style('ar_file-input', plugins_url('css/fileinput.min.css', __FILE__) );
    
    wp_enqueue_style('ar_style_css');
    wp_enqueue_style('ar_bootstrap-style');
    wp_enqueue_style('ar_file-input');
}
add_action( 'wp_enqueue_scripts', 'register_ar_styles' );


//JS PUBLIC
function register_ar_js_script(){   
    //wp_register_script('jquery-js', plugins_url('area_riservata/js/jquery-3.2.1.min.js'), array('jquery'), '1.0', false);
    wp_register_script('ui-widget-js', plugins_url('area_riservata/js/jquery-ui.min.js'), array('jquery'), '1.0', false);       
    wp_register_script('file-input', plugins_url('area_riservata/js/fileinput.min.js'), array('jquery'), '1.0', false); 
    wp_register_script('livequery', plugins_url('area_riservata/js/jquery.livequery.js'), array('jquery'), '1.0', false);       
    wp_register_script('script', plugins_url('area_riservata/js/script.js'), array('jquery'), '1.0', false);   
      
    //wp_enqueue_script('jquery-js'); 
    wp_enqueue_script('ui-widget-js'); 
    wp_enqueue_script('file-input'); 
    wp_enqueue_script('livequery');
    wp_enqueue_script('script'); 
}
add_action( 'wp_enqueue_scripts', 'register_ar_js_script' );


//AJAX CALL




/**
 * La funzione fa redirect sulla pagina di Area Riservata
 */
function my_login_redirect( $url, $request, $user ){
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if( $user->has_cap( 'administrator' ) ) {
            $url = admin_url();
        } else {
            $url = home_url('/area-riservata/');
        }
    }
    return $url;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );



/**
 * Rimuovo l'admin bar dagli utenti che non sono amministratori
 */
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');
?>