<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

namespace area_riservata;

//TABELLE DATABASE
global $DB_PREFIX;
global $DB_TABLE_FILES;

global $FORM_TF_UTENTE, $FORM_TF_DESC, $FORM_TF_URL, $FORM_TF_SUBMIT;

global $LABEL_TF_UTENTE, $LABEL_TF_DESC, $LABEL_TF_URL, $LABEL_TF_SUBMIT;


//DATABASE
$DB_PREFIX = 'ar_';
$DB_TABLE_FILES = 'files';

//TABELLA FILES
$FORM_TF_UTENTE = 'tf_utente';
$FORM_TF_DESC = 'tf_descrizione';
$FORM_TF_URL = 'tf_url';
$FORM_TF_SUBMIT = 'tf_submit';

$LABEL_TF_UTENTE = 'Utente';
$LABEL_TF_DESC = 'Descrizione';
$LABEL_TF_URL = 'Carica file';
$LABEL_TF_SUBMIT = 'Salva';



?>