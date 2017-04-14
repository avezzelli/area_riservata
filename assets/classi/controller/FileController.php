<?php

namespace area_riservata;
/**
 * Description of FileController
 *
 * @author Alex
 */
class FileController {
   private $fDAO;
   
   /**
    * Costruttore
    */
   function __construct() {
       $this->fDAO = new FileDAO();
   }
   
   /**
    * La funzione salva un file nel database
    * @param \area_riservata\File $f
    * @return boolean
    */
   public function saveFile(File $f){
       if($this->fDAO->saveFile($f) == false){
           return false;
       }
       return true;
   }
   
   /**
    * La funzione restituisce tutti i file associati ad un utente
    * Se non esistono, restituisce null
    * @param type $idUtente
    * @return type
    */
   public function getFilesFromUtente($idUtente){
       $query = array(
            array(
                'campo'   => 'id_utente',
                'valore'  => $idUtente,
                'formato' => 'INT'
            )
       );      
       return $this->fDAO->getFiles($query);
   }
   
   
   /**
    * La funzione elimina un singolo file, conoscendone l'ID
    * @param type $ID
    * @return type
    */
   public function deleteFile($ID){
       return $this->fDAO->deleteFileByID($ID);
   }
   
   /**
    * La funzione elimina tutti i file associati ad un determinato utente
    * @param type $idUtente
    * @return type
    */
   public function deleteFilesFromUtente($idUtente){
       return $this->fDAO->deleteFiles($idUtente);
   }

}
