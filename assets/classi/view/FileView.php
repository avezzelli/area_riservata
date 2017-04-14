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
        
        global $FORM_TF_UTENTE, $FORM_TF_DESC, $FORM_TF_URL;
        $this->form['utente'] = $FORM_TF_UTENTE;
        $this->form['descrizione'] = $FORM_TF_DESC;
        $this->form['url'] = $FORM_TF_URL;
        
        global $LABEL_TF_UTENTE, $LABEL_TF_DESC, $LABEL_TF_URL;
        $this->label['utente'] = $LABEL_TF_UTENTE;
        $this->label['descrizione'] = $LABEL_TF_DESC;
        $this->label['url'] = $LABEL_TF_URL;
    }
    
    
    public function printFormInserimentoFiles($idUtente){
    ?>
        <form class="form-horizontal inserimento-files" role="form" action="<?php echo curPageURL() ?>" name="form-files" method="POST">
            <?php parent::printHiddenFormField($this->form['utente'], $idUtente) ?>
            <div class="container-files">
                <div class="container-file">
                    <?php parent::printTextFormField($this->form['descrizione'], $this->label['descrizione']) ?>
                    <?php parent::printInputFileField($this->form['url'], $this->label['url']) ?>
                    <hr>
                </div>
            </div>
           
            <a class="add-file">Aggiungi un altro file</a>
            

        </form>
    <?php
    }

    
    
}
