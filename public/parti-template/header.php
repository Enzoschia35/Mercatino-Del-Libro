<?php

    $Cm = new ManagerCarrello();
    $id_carrello = $Cm->getIdCarrelloCorrente();
    $totale_carrello = $Cm->getTotaleCarrello($id_carrello);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vesuviano Book Store | compra-vendi online</title>
    <link rel="icon" type="image/x-icon" href="<?php ROOT_URL; ?>images/local/icona.jpg">
    <link rel="stylesheet" href="https://bootswatch.com/5/cosmo/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Main personal style -->
    <style>
        body{
            background-color: whitesmoke;
            
        }
        #suggerimenti_funzione {
            position: absolute;
            top: calc(100% + 10px); /* Spazio di 10px dalla parte inferiore del campo di input */
            left: 0;
            background-color: rgba(255, 255, 255, 0.9); /* Bianco con trasparenza al 10% */
            border: 1px solid #ccc;
            width: 100%; /* Larghezza uguale al campo di input */
            max-height: 300px; /* Altezza massima dei suggerimenti */
            overflow-y: auto; /* Abilita lo scorrimento verticale se necessario */
            z-index: 1000; /* Assicura che sia sopra gli altri elementi */
        }

        .suggerimento {
            display: block;
            padding: 5px;
            border-bottom: 1px solid #eee; /* Bordo inferiore per separare i suggerimenti */
            text-decoration: none; /* Rimuove il sottolineato predefinito */
            color: #333; /* Colore del testo */
        }

        .suggerimento:hover {
            background-color: #f5f5f5; /* Colore di sfondo al passaggio del mouse */
        }

        .button-icon {
            border: none;
            background: none;
            padding: 0;
        }
        .no-link {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }
        .card {
            transition: transform 0.2s, box-shadow 0.2s; /* Aggiunta transizione per l'ombra */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Aggiunta ombra */
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4); /* Ombra più intensa quando si passa sopra */
        }

        .card-img-top {
            height: 225px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }

        .btn-group .btn,
        .btn-group form {
            flex: 1;
        }

        .mt-auto {
            margin-top: auto;
        }

        .card-body small.text-muted {
            display: block;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: white;
        }

        .btn-group.d-flex .btn,
        .btn-group.d-flex form .btn {
            width: 100%;
            text-align: center;
            padding: 10px; /* Aggiunto padding per aumentare la dimensione dei pulsanti */
        }

        .btn-group.d-flex .btn + form {
            margin-left: 10px; /* Aumentato il margine sinistro per separare i pulsanti */
        }
    </style>


    <!-- script suggerimenti -->
    <script>
        function suggerisci_titolo() {
            var stringa = document.getElementById('ctrl_cerca_suggest').value;
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('suggerimenti_funzione').innerHTML = this.responseText;
                }
            };

            // Invia una richiesta GET con la stringa di ricerca come parametro
            xhr.open("GET", "<?php echo ROOT_URL;?>utility/php/suggerimenti_query.php?stringa_ricerca=" + encodeURIComponent(stringa), true);
            xhr.send();
        }
    </script>
   
<?php
if (isset($_GET['ricerca'])) {
   
    $titolo = isset($_GET['ricerca']) ? htmlspecialchars($_GET['ricerca']) : '';
    $prezzoMin = isset($_GET['prezzoMin']) ? htmlspecialchars($_GET['prezzoMin']) : '';
    $prezzoMax = isset($_GET['prezzoMax']) ? htmlspecialchars($_GET['prezzoMax']) : '';
    $condizioni = isset($_GET['condizioni']) ? htmlspecialchars($_GET['condizioni']) : '';

    $productMgr = new ManagerProdotti();
    $products = $productMgr->getFilteredProducts($titolo, $prezzoMin, $prezzoMax, $condizioni);
}

if(isset($_POST['ctrl_submit_suggest']))
{
    echo 'ok get';
}
?>
   
</head>
<body>
 
    <nav class="navbar navbar-expand-lg bg-ligth" data-bs-theme="white">
        <div class="container navbar-collapse" > 
            <a class="navbar-brand" href="<?php echo ROOT_URL;?>public?page=homepage">HOME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

            <div class="collapse navbar-collapse" id="navbarColor03">
            
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL;?>shop?page=catalogo">ESPLORA ANNUNCI</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL;?>shop?page=vendi">VENDI</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">ABOUT</a>
                    </li>
                    
                    

                </ul> 

                <!-- CARRELLO -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL;?>shop?page=carrello">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if(isset($totale_carrello["num_elementi"])) : ?>
                        <span class="badge  rounded-pill bg-success js-totCartItems" ><?php echo $totale_carrello["num_elementi"]; ?></span>
                        <?php endif; ?>

                    </a>
                    </li>
                </ul>


                <!--  MENU' CASCATA PER UTENTI VISITATORI NON LOGGATI-->
                <?php if(!$loggedInUser):  ?>
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Area Riservata</a>
                        <div class="dropdown-menu">
                        
                                <a class="dropdown-item" href="<?php echo ROOT_URL;?>auth?page=login">Login <i class="fa-solid fa-right-to-bracket"></i></a>

                            <a class="dropdown-item" href="<?php echo ROOT_URL;?>shop?page=catalogo">Catalogo</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                        </li>
                    </ul> 
                <?php endif; ?> 


                <!--  MENU' CASCATA PER UTENTI LOGGATI-->
                <?php if($loggedInUser):  ?>
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo $loggedInUser->username ?>
                            </a>
                        <div class="dropdown-menu">
                        
                                <a class="dropdown-item" href="<?php echo ROOT_URL;?>auth?page=logout">Logout <i class="fa-solid fa-heart-crack"></i></a>

                            <a class="dropdown-item" href="<?php echo ROOT_URL;?>public?page=catalogo">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                        </li>
                    </ul> 
                <?php endif; ?> 

                <!--  MENU' CASCATA PER AMMINISTRAZIONE-->
                <?php if($loggedInUser && $loggedInUser->is_admin):  ?>
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                Amministrazione
                            </a>
                        <div class="dropdown-menu">
                        
                                <a class="dropdown-item" href="<?php echo ROOT_URL;?>admin?page=dashboard">Dashboard</a>

                            <a class="dropdown-item" href="<?php echo ROOT_URL;?>public?page=catalogo">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                        </li>
                    </ul> 
                <?php endif; ?> 


                <!-- FORM  RICERCA -->
                <?php if($page == 'catalogo'  || $page == 'homepage') :  ?>

                    <form class="d-flex" method="post"><!--style="border: 4px solid green;"-->
                        <div class="collapse navbar-collapse" style="position:relative;" id="navbarColor03">
                            <input class="form-control me-sm-2" type="search"  name="ctrl_cerca_suggest" id="ctrl_cerca_suggest" placeholder="Cerca qui..."  onkeyup=suggerisci_titolo()> <!-- onkeyup=suggerisci_titolo()-->
                            <div class="container " style="position:absolute;" id="suggerimenti_funzione"></div><!--style="border: 4px solid yellow;"-->
                        </div>    
                            <a class="btn btn-primary " name="ctrl_submit_suggest" type="submit" ><i class="fas fa-search"></i></button></a>
                            <br>
                    </form>
                <?php endif; ?>
                <!-- FORM  RICERCA -->
            </div>
        
        </div>
        
            
    </nav>
