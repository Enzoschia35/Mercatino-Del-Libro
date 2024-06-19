<?php

// Se la costante root non è definita allora si sta cercando di manipolare il funzionamento del sistema
if (!defined('ROOT_URL')) {
    // Se un utente cerca di accedere direttamente ad una risorsa viene mostrato schermo bianco
    die;
}



// OGGETTO MANAGER PER METODI DB
$productMgr = new ManagerProdotti();

$risultati_per_pagina = 6;

if(isset($_GET['num_page'])){
    if($_GET['num_page']>1){
        $start = ($_GET['num_page']-1) * $risultati_per_pagina; //ottengo il record da cui partire
        
    } else{
        $start = 0;
    }

}else{
    $start = 0;
}


$res = $productMgr->contaArticoli();


$risultati_totali = $res[0]['conteggio'];
$totale_pagine = ceil($risultati_totali / $risultati_per_pagina);

$products = $productMgr->getArticoliPubblici($start,$risultati_per_pagina);




if (isset($_POST["add_to_cart"])) {
    $id_prodotto = htmlspecialchars($_POST['id_prod']);
    // aggiungo al carrello
    $Cm = new ManagerCarrello();
    $id_carrello = $Cm->getIdCarrelloCorrente();
    
    // aggiungi al carrello 'id_carello' il prodotto 'id_prodotto'
    $Cm->aggiungiAlCarrello($id_prodotto, $id_carrello);
    
    // Redirect to cart page
    echo "<script> location.href='" . ROOT_URL .  "shop?page=carrello' </script>";
    exit;
}

if (isset($_POST['vedi_annuncio'])) {
    $id_prodotto = htmlspecialchars($_POST['id_prod']);
    // Redirect to product page
    echo "<script> location.href='" . ROOT_URL . "shop?page=vedi-prodotto&id=$id_prodotto' </script>";
    exit;
}

if (isset($_GET['applica_filtri'])) {
    $titolo = isset($_GET['titolo']) ? htmlspecialchars($_GET['titolo']) : '';
    $prezzoMin = isset($_GET['prezzoMin']) ? htmlspecialchars($_GET['prezzoMin']) : '';
    $prezzoMax = isset($_GET['prezzoMax']) ? htmlspecialchars($_GET['prezzoMax']) : '';
    $condizioni = isset($_GET['condizioni']) ? htmlspecialchars($_GET['condizioni']) : '';

    //--------------------------
    $res = $productMgr->getFilteredProducts($titolo, $prezzoMin, $prezzoMax, $condizioni);
    $risultati_totali = $res[0]['conteggio'];
    $totale_pagine = ceil($risultati_totali / $risultati_per_pagina);
    
    $products = $productMgr->getFilteredProductsPaginazione($titolo, $prezzoMin, $prezzoMax, $condizioni,$start,$risultati_per_pagina);
}

if (isset($_GET['ricerca'])) {
   
    $titolo = isset($_GET['ricerca']) ? htmlspecialchars($_GET['ricerca']) : '';
    $prezzoMin = isset($_GET['prezzoMin']) ? htmlspecialchars($_GET['prezzoMin']) : '';
    $prezzoMax = isset($_GET['prezzoMax']) ? htmlspecialchars($_GET['prezzoMax']) : '';
    $condizioni = isset($_GET['condizioni']) ? htmlspecialchars($_GET['condizioni']) : '';

    //------------------------------------------------------
    $res = $productMgr->getFilteredProducts($titolo, $prezzoMin, $prezzoMax, $condizioni);
    $risultati_totali = $res[0]['conteggio'];
    $totale_pagine = ceil($risultati_totali / $risultati_per_pagina);

    $products = $productMgr->getFilteredProductsPaginazione($titolo, $prezzoMin, $prezzoMax, $condizioni, $start,$risultati_per_pagina);
}

if(isset($_GET['ctrl_submit_suggest']))
{
    echo 'ok get';
}

?>




<div class="container">
    <div class="row mb-4">
        <!-- Filtri -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filtri</h5>
                    <!-- Form dei filtri -->
                    <form method="get" class="d-flex flex-wrap">
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="prezzoMin" class="form-label">Prezzo minimo</label>
                            <input type="number" class="form-control" id="prezzoMin" min="1" step="any" name="prezzoMin" placeholder="Inserisci min">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="prezzoMax" class="form-label">Prezzo massimo</label>
                            <input type="number" class="form-control" id="prezzoMax" min="1" step="any" name="prezzoMax" placeholder="Inserisci max">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="condizioni" class="form-label">Condizioni</label>
                            <select class="form-select" id="condizioni" name="condizioni">
                                <option value="Tutte">Tutte le condizioni</option>
                                <option value="Nuovo">Nuovo</option>
                                <option value="Come Nuovo">Come Nuovo</option>
                                <option value="Ottime Condizioni">Ottime Condizioni</option>
                                <option value="Buone Condizioni">Buone Condizioni</option>
                                <option value="Condizioni Scadenti">Condizioni Scadenti</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label for="apllica_filtri" class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100" id="applica_filtri" name="applica_filtri" value="1">
                                Applica Filtri <i class="fa-solid fa-check"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Catalogo -->
        <div class="col-md-9">
            <div class="row">
                <?php if ($products) : ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <?php
                                    // Costruisci la query string con i parametri dei filtri
                                    $query_string = $_SERVER['QUERY_STRING'];
                                    $product_url = ROOT_URL . 'shop?' . $query_string . '&page=vedi-prodotto&id='. $product['id'];
                                    
                                ?>
                                <a href="<?php echo $product_url; ?>"><img class="card-img-top" src="<?php echo ROOT_URL . $product['img_path']; ?>"></a>
                                <div class="card-body">
                                    <a class="no-link" href="<?php echo $product_url; ?>">
                                        <h5 class="card-title"><?php echo $product['titolo']; ?></h5>
                                        <p class="card-text"><?php echo $product['prezzo']; ?> €</p>
                                        <p class="card-text"><?php echo $product['condizioni']; ?></p>
                                    </a>
                                </div>
                                <div class="text-center card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <form method="post">
                                        <input type="hidden" name="id_prod" value="<?php echo $product['id']; ?>">
                                        <button class="btn btn-outline-dark mt-auto text-center" type="submit" name="add_to_cart">
                                            Aggiungi al carrello <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                    <small class="text-muted">Pubblicato il <?php echo $product['data_public']; ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="alert alert-primary text-center" role="alert">
                            Nessun prodotto disponibile.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
              <!-- Pagination -->
               <?php 
                $query_string_pagina = $_SERVER['QUERY_STRING'];
                $paginazione_url = ROOT_URL . 'shop?' . $query_string_pagina . '&num_page';
               
               ?>
               <?php if($totale_pagine>1) : ?>
              <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="<?php echo $paginazione_url;?>'=1">Prima</a></li>
                    <?php
                     
                    for($x = 1; $x <= $totale_pagine; $x++){
                        
                        echo " <li class='page-item'><a class='page-link' href='$paginazione_url=$x'>$x</a></li>";
                    }
                   ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $paginazione_url;?>=<?php echo $totale_pagine;?>">Ultima</a></li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>


