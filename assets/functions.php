<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

namespace area_riservata;

/**
 * La funzione installa il database
 * @global type $DB_TABLE_FILES
 * @return boolean
 */
function install_AreaRiservata(){
    global $DB_TABLE_FILES;
    
    try{
        //FILES
        $args = array(
            array(
                'nome' => 'id_utente',
                'tipo' => 'INT',
                'null' => 'NOT NULL'
            ),
            array(
                'nome' => 'url_file',
                'tipo' => 'TEXT',
                'null' => 'NOT NULL'
            ),
            array(
                'nome' => 'descrizione',
                'tipo' => 'TEXT',
                'null' => null
            )            
        );
        creaTabella($DB_TABLE_FILES, $args);
        
    } catch (Exception $ex) {
         _e($ex);        
        return false;
    }
}

/**
 * La funzione elimina il database
 * @global \area_riservata\type $DB_TABLE_FILES
 * @return boolean
 */
function drop_AreaRiservata(){
    global $DB_TABLE_FILES;
    
    try{
        dropTabella($DB_TABLE_FILES);
    } catch (Exception $ex) {
        _e($ex);        
        return false;
    }
}


function create_admin_pages(){
    //devo creare una pagina per l'area riservata
    $post = array(
        'post_title'    => 'Area Riservata',
        'post_content'  => '[AreaRiservata]',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
        'post_name'     => 'area-riservata'
    );
    wp_insert_post($post);
}


function delete_admin_page(){
    $page = get_page_by_title( 'Area Riservata' );
    wp_delete_post($page->ID);
}


function curPageURL() {
    $pageURL = 'http';
    
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

?>