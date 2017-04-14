<?php

namespace area_riservata;

/**
 * Description of File
 *
 * @author Alex
 */
class File {
    private $ID;
    private $idUtente;
    private $urlFile;
    private $descrizione;
    
    function getID() {
        return $this->ID;
    }

    function getIdUtente() {
        return $this->idUtente;
    }

    function getUrlFile() {
        return $this->urlFile;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setIdUtente($idUtente) {
        $this->idUtente = $idUtente;
    }

    function setUrlFile($urlFile) {
        $this->urlFile = $urlFile;
    }
    
    function getDescrizione() {
        return $this->descrizione;
    }

    function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }




}
