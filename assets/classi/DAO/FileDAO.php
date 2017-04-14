<?php

namespace area_riservata;

/**
 * Description of FileDAO
 *
 * @author Alex
 */
class FileDAO extends ObjectDAO {
    
    //costruttore
    function __construct() {
        global $DB_TABLE_FILES;
        parent::__construct($DB_TABLE_FILES);
    }
    
    /**
     * La funzione salva un file associato ad un utente nel database
     * @param \area_riservata\File $f
     * @return type
     */
    public function saveFile(File $f){        
        $campi = array(
            'id_utente' => $f->getIdUtente(),
            'url_file'  => $f->getUrlFile(),
            'descrizione' => $f->getDescrizione()
        );
        
        $formato = array('%d', '%s', '%s');
        return parent::saveObject($campi, $formato);
    }
    
    /**
     * La funzione restituisce un array di files
     * @param type $where
     * @return array
     */
    public function getFiles($where = null){
        $result = null;
        $temp = parent::getObjects(null, $where);
        if(count($temp) > 0){
            $result = array();
            foreach($temp as $item){
                $f = new File();
                $f->setID($item->ID);
                $f->setIdUtente($item->id_utente);
                $f->setUrlFile($item->url_file);
                $f->setDescrizione($item->descrizione);
                array_push($result, $f);
            }
        }
        return $result;
    }
    
    /**
     * La funzion elimina un singolo file passato per ID
     * @param type $ID
     * @return type
     */
    public function deleteFileByID($ID){
        return parent::deleteObjectByID($ID);
    }
    
    /**
     * La funzione elimina tutti i file associati ad un utente
     * @param type $idUtente
     * @return type
     */
    public function deleteFiles($idUtente){
        $array = array('id_utente' => $idUtente);
        return parent::deleteObject($array);
    }
}
