<?php
// Prevent from direct access
if (! defined('ROOT_URL')) {
    die;
}
$errMsg = null;
?>
<?php 

$pM = new ManagerProdotti();
$res = $pM->getArticoliDaApprovare();

if(count($res)>0){
  $errMsg = 'Ciao '. $loggedInUser->username . ', hai degli annunci da verificare :)';
}

?>

  <style>
        /* Personalizzazioni CSS aggiuntive */
        body {
            background-color: #f8f9fa;
        }

        .dashboard-header {
            background-color: blue; /* Colore di sfondo viola */
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header img {
            max-width: 48px;
            height: auto;
        }

        .dashboard-content {
            background-color: #ffffff; /* Sfondo bianco */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .list-group-item {
            background-color: #f0f0f0; /* Colore di sfondo grigio chiaro */
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .list-group-item a {
            display: block;
            padding: 15px;
            color: none;
            font-weight: bold;
        }

        .list-group-item a:hover {
            background-color: #e0e0e0; /* Cambia colore al passaggio del mouse */
            text-decoration: none;
        }

        .list-group-item .badge {
            background-color: blue; /* Colore viola per la freccia » */
            color: white;
            font-size: 0.8rem;
            margin-left: auto;
            padding: 8px;
            border-radius: 20px;
        }
  </style>

<div class="container">
    <div class="dashboard-header">
        <div class="d-flex align-items-center">
            <img class="me-3" src="../images/local/admin_icon.png" alt="">
            <div>
                <h1 class="h2 mb-0">Il Cruscotto Amministrativo di <?php echo $loggedInUser->username; ?></h1>
            </div>
        </div>
    </div>
    <?php if ($errMsg) : ?>
        <div class="alert alert-warning rounded-1 text-center" role="alert">
            <?php echo $errMsg; ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-content">
        <h3 class="border-bottom pb-2 mb-4">Opzioni Disponibili</h3>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?php echo ROOT_URL; ?>admin?page=lista-utenti" class="text-decoration-none text-dark">
                    Lista Utenti <span class="badge">&raquo;</span>
                </a>
                <p class="text-decoration-none text-dark">Permette di visualizzare la lista e degli utenti registrati e di eseguire operazioni su di essi</p>
            </li>
            <li class="list-group-item">
                <a href="<?php echo ROOT_URL; ?>admin?page=approva-annunci" class="text-decoration-none text-dark">
                    Annunci da verificare <span class="badge">&raquo;</span>
                </a>
                <p class="text-decoration-none text-dark">Permette di visualizzare la lista degli annunci in fase di verifica e di eseguire operazioni su di essi</p>
            </li>
            <li class="list-group-item">
            <a href="<?php echo ROOT_URL; ?>admin?page=annunci-pubblici" class="text-decoration-none text-dark">
                    Annunci pubblici <span class="badge">&raquo;</span>
                </a>
                <p class="text-decoration-none text-dark">Permette di visualizzare la lista degli annunci pubblici e di eseguire operazioni su di essi</p>
            </li>
            
        </ul>
    </div>
</div>




    <!--
<div class="container">
    <div class="d-flex align-items-center p-3 my-3 bg-purple text-white rounded shadow-sm" style="background-color: blue;">
        <img class="me-3" src="../images/local/admin_icon.png" alt="" width="48" height="38">
        <div>
            <h1 class="h2 mb-0 lh-1">Il Cruscotto amministrativo di <?php echo $loggedInUser->username; ?></h1>
        </div>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h3 class="border-bottom pb-2 mb-0">Opzioni disponibili</h3>

        <ul class="list-group list-group-flush mt-3">
            <li class="list-group-item">
                <a href="<?php echo ROOT_URL; ?>admin?page=lista-utenti" class="text-decoration-none text-dark">
                    Lista Utenti <span class="badge bg-primary rounded-pill">&raquo;</span>
                </a>
            </li>
            <li class="list-group-item">
                <a href="<?php echo ROOT_URL; ?>admin?page=approva-annunci" class="text-decoration-none text-dark">
                    Approva Annunci <span class="badge bg-primary rounded-pill">&raquo;</span>
                </a>
            </li>
            <li class="list-group-item">
                <a href="<?php echo ROOT_URL; ?>admin?page=altro-link" class="text-decoration-none text-dark">
                    Altro Link <span class="badge bg-primary rounded-pill">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
</div> -->
