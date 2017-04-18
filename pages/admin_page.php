<?php
namespace area_riservata;
//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

//LISTENER CREA UTENTE
if(isset($_POST['submit'])){
    $userdata = array(
        'user_pass'     => $_POST['InputPassword'],
        'user_login'    => $_POST['InputUser'],
        'user_email'    => $_POST['InputEmail'],
        'first_name'    => $_POST['InputNome'],
        'last_name'     => $_POST['InputCognome'],
        'role'          => 'subscriber'
    );
    
    $temp = wp_insert_user($userdata); 
    
    if(is_wp_error($temp) == false){
        echo '<div class="alert alert-success">
            <strong>OK! </strong> Utente creato con successo!
        </div>';
    }
    else{
        
        
        echo '<div class="alert alert-danger">
            <strong>Errore! </strong> '.$temp->get_error_message().'</div>';
    }
}

//LISTENER CANCELLA UTENTE
if(isset($_POST['cancella-utente'])){            
    //elimino tutti i file associati all'utente in questione
    $fc = new FileController();    
    if($fc->deleteFilesFromUtente($_POST['idUtente'])){
        //elimino l'utente di wordpress
        require_once(ABSPATH.'wp-admin/includes/user.php');
        if(wp_delete_user($_POST['idUtente'])){
            echo '<div class="alert alert-success">
            <strong>OK! </strong> Utente eliminato con successo!
        </div>';
          
           
        }
        else{
            echo '<div class="alert alert-danger">
            <strong>Errore! </strong> Errore nell\'eliminazione dell\'utente.
        </div>';
            
        }
    }
}

//OTTENGO GLI UTENTI
$args = array(
    'role'  => 'subscriber'
);

$users = get_users($args);

?>
<a class="float-right" href="<?php echo wp_logout_url(curPageURL() )?>">
    <span class="back-text">LOGOUT</span>
</a>
<div class="container-admin">
    <h2>Gestione area riservata</h2>
    <ul class="nav nav-tabs">
        <li data-name="view" class="active"><a data-toggle="tab" href="#view">Visualizza Utenti</a></li>
        <?php if(isset($_GET['utente'])){ ?>
            <li data-name="utente"><a data-toggle="tab" href="#utente">Dettagli utente</a></li>
        <?php } ?>
        <li data-name="crea"><a data-toggle="tab" href="#crea">Crea Utente</a></li>
    </ul>
    
    <div class="tab-content">
        <div id="view" class="tab-pane fade in active">
            <h3>Visualizza Utenti</h3>
            <?php if(count($users) > 0){ ?>
                <table class="table">
                    <thead>
                      <tr>
                        <th>Utente</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user){ 
                            $u = get_user_by('ID', $user->data->ID);
                    ?>
                        <tr>
                            <td><?php echo $u->user_login ?></td>
                            <td><?php echo $u->user_firstname; ?></td>
                            <td><?php echo $u->last_name; ?></td>
                            <td><?php echo $u->user_email; ?></td>
                            <td><a href="<?php echo home_url() ?>/area-riservata?utente=<?php echo $u->ID ?>">Visualizza dettagli</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
              </table>
            <?php } else { ?>
                <p>Nessun utente presente.</p>
            <?php } ?>
            
        </div>
        
        <?php if(isset($_GET['utente'])){ ?>
           
        <?php 
            $user = get_user_by('ID', $_GET['utente']);
            
        ?>
        
        <div id="utente" class="tab-pane fade">
            <?php 
                if($user != false){
                    $viewA = new FileView();
                $viewA->listenerFormInserimento();
            ?>
            <h3>Dettaglio Utente</h3>
            <div class="col-xs-12 col-sm-3"><strong>Utente</strong><br><?php echo $user->user_login ?></div>
            <div class="col-xs-12 col-sm-3"><strong>Nome</strong><br><?php echo $user->user_firstname.' '.$u->last_name ?></div>
            <div class="col-xs-12 col-sm-3"><strong>Email</strong><br><?php echo $user->user_email ?></div>
        
            <div class="clear"></div>
            <form action="<?php echo curPageURL() ?>" method="POST">
                <input type="hidden" name="idUtente" value="<?php echo $_GET['utente'] ?>">
                
                <input class="float-right" type="submit" value="Cancella Utente" name="cancella-utente" />
            </form>
            
            <div class="clear"></div>
            <?php $viewA->printTabellaFiles($_GET['utente']) ?>
            
            <div class="clear"></div>
            <?php $viewA->printFormInserimentoFiles($user->ID) ?>
            <?php
                }
                else{
                    echo '<p>L\'utente non è presente nel sistema.</p>';
                }
            ?>
            <div class="clear"></div>
            <p style="margin-top:40px"><strong>NOTA BENE</strong><br>Per sicurezza alcuni tipi di file non possono essere caricati direttamente. Per ovviare questo problema si consiglia di inserirlo in un archivio .zip o .rar e ricaricare il tutto. </p>
        </div> 
        
               
        <?php 
            
        
            }?>
        
        
        <div id="crea" class="tab-pane fade">
            <h3>Crea Utente</h3>
            
            <form method="POST" action="<?php echo curPageURL() ?>#crea">
                <div class="form-group">
                    <label for="InputEmail">Email address *</label>
                    <input type="email" class="form-control" name="InputEmail" id="InputEmail" placeholder="Email" required>
                </div>  
                <div class="form-group">
                    <label for="InputUser">User *</label>
                    <input type="text" class="form-control" name="InputUser" id="InputUser" placeholder="User" required>
                </div>
                <div class="form-group">
                    <label for="InputPassword">Password *</label>
                    <input type="password" class="form-control" name="InputPassword" id="InputPassword" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="InputNome">Nome</label>
                    <input type="text" class="form-control" name="InputNome" id="InputNome" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label for="InputCogome">Cognome</label>
                    <input type="text" class="form-control" name="InputCognome" id="InputCognome" placeholder="Cognome">
                </div> 
                <button class="float-right" type="submit" name="submit" class="btn btn-default">Crea Utente</button>
            </form>
        </div>
    </div>
    
