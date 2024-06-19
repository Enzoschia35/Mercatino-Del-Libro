<?php
    session_start();
    require_once('../inizializzazione/globali.php');
    require_once ROOT_PATH . 'inizializzazione/connection_db.php';
    require_once ROOT_PATH . 'inizializzazione/funzioni.php';
    require_once ROOT_PATH . 'classi/DB.php';
    require_once ROOT_PATH . 'classi/manager-prodotti.php';
    require_once ROOT_PATH . 'classi/manager-img.php';
    require_once ROOT_PATH . 'classi/manager-carrello.php';
    require_once ROOT_PATH . 'classi/manager-utenti.php';
    


    //var_dump($loggedInUser);

