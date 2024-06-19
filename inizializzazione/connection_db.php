<?php
    //dichiaro tutte le mie variabili globali
    
    //OGGETTO DI CONNESSIONE
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $loggedInUser = null; //inizalmente null, una volta che l'utente effettua il login questa variabile assumerà come valore l'utente correntemente loggato
    
    //se ho un utente in sessione salvo in logged i dati utente
    if(isset($_SESSION['user']))
    {
        $loggedInUser = $_SESSION['user'];
    }
