<?php


namespace area_riservata;

/**
 * Description of FileView
 *
 * @author Alex
 */
class FileView extends PrinterView {
    private $fC;
    private $form;
    private $label;
    
    function __construct() {
        parent::__construct();
        $this->fC = new FileController();
        
        global $FORM_TF_UTENTE, $FORM_TF_DESC, $FORM_TF_URL, $FORM_TF_SUBMIT;
        $this->form['utente'] = $FORM_TF_UTENTE;
        $this->form['descrizione'] = $FORM_TF_DESC;
        $this->form['url'] = $FORM_TF_URL;
        $this->form['submit'] = $FORM_TF_SUBMIT;
        
        
        global $LABEL_TF_UTENTE, $LABEL_TF_DESC, $LABEL_TF_URL, $LABEL_TF_SUBMIT;
        $this->label['utente'] = $LABEL_TF_UTENTE;
        $this->label['descrizione'] = $LABEL_TF_DESC;
        $this->label['url'] = $LABEL_TF_URL;
        $this->label['submit'] = $LABEL_TF_SUBMIT;
    }
    
    
    public function printFormInserimentoFiles($idUtente){
    ?>
        <form class="form-horizontal inserimento-files" role="form" action="<?php echo curPageURL() ?>" name="form-files" method="POST" enctype="multipart/form-data">
            <?php parent::printHiddenFormField($this->form['utente'], $idUtente) ?>
            <div class="container-files">
                <div class="container-file">
                    <?php parent::printTextFormField($this->form['descrizione'], $this->label['descrizione']) ?>
                    <?php parent::printInputFileField($this->form['url'], $this->label['url'], true) ?>
                    <hr>
                </div>
            </div>
           
            <a class="add-file">Aggiungi un altro file</a>
            
            <div class="clear"></div>
            <div class="float-right">
                <?php parent::printSubmitFormField($this->form['submit'], $this->label['submit']) ?>
            </div>
        </form>
    <?php
    }
    
    
    public function listenerFormInserimento(){
        if(isset($_POST[$this->form['submit']])){
            
            //salvo il file con wordpress
            //ciclo sull'array $_FILES
            $url = array();            
            
            if(count($_FILES) > 0){
                //upload su wp
                foreach($_FILES as $key => $value){ 
                    $upload = wp_upload_bits($value["name"], null, file_get_contents($value["tmp_name"]));
                    
                    if($upload['error'] != false){
                        parent::printErrorBoxMessage($upload['error']);              
                        return;
                    }
                    
                    //carico gli url degli upload in un array temporaneo
                    array_push($url, $upload['url']);
                }
               
                //ciclo all'interno di $_POST a cercare le variabili tf_descrizione
                $count = 0;
                foreach($_POST as $key => $value){
                    
                    if (strpos($key, $this->form['descrizione']) !== false) {
                        //associo le url con con la descrizione
                        $f = new File();
                        $f->setDescrizione($value);
                        $f->setUrlFile($url[$count]);
                        $f->setIdUtente($_POST[$this->form['utente']]);
                        $this->fC->saveFile($f);
                        $count++;
                    }
                    
                }
                
                unset($_POST);
                
            }            
        }
        
        if(isset($_POST['cancella-file'])){
            if($this->fC->deleteFile($_POST['ID']) == true){
                parent::printOkBoxMessage('File eliminato con successo!');
                
            }else{
                parent::printErrorBoxMessage('Errore nell\'eliminazione del file');
            }
            
        }     
        
    }
    
    
    public function printTabellaFiles($idUtente){        
        
        $files = $this->fC->getFilesFromUtente($idUtente);
        
        if(count($files) > 0){
        
            $user = wp_get_current_user();

            if($user->has_cap('administrator') || $user->has_cap('editor')){
                $header = array(
                    $this->label['descrizione'],
                    'Azione'
                );
            }

            if($user->has_cap('subscriber')){
                $header = array(
                    $this->label['descrizione'].' File',
                    'Azione'
                );
            }

            $bodyTable = $this->printBodyTable($files);
            parent::printTableHover($header, $bodyTable);
        }
        else{
            echo '<p>Non ci sono ancora file associati a questo utente</p>';
        }
        
    }
    
    
    protected function printBodyTable($array){
        parent::printBodyTable($array);
        $html = "";
        $counter = 1;
        
        $user = wp_get_current_user();
        
        $counter = 1;
        
        foreach($array as $item){
            $f = new File();
            $f = $item;
            
            $nomeFile = 'File numero '.$counter;
            
            if(trim($f->getDescrizione() != '') && $f->getDescrizione() != null){
                $nomeFile = $f->getDescrizione();
            }
            
            $html.='<tr>';
           
           
            
            if($user->has_cap('administrator') || $user->has_cap('editor')){
                $html.= '<td><a href="'.$f->getUrlFile().'" target="_blank">'.$nomeFile.'</a></td>';
                $html.= '<td>'
                        . '<form action="'. curPageURL().'" method="post" >'
                        . '<input type="hidden" name="ID" value="'.$f->getID().'" />'
                        . '<input type="submit" name="cancella-file" class="delete" value="cancella" />'
                        . '</form>'
                     . '</td>';
            }
            
            if($user->has_cap('subscriber')){
                $html.='<td>'.$nomeFile.'</td>';
                $html.='<td><a href="'.$f->getUrlFile().'" target="_blank">Apri / Scarica</a></td>';
            }
            
            $html.='</tr>';
            $counter++;
        }
        
        
        return $html;
    }

    
    
}
