<?php
// Se la costante ROOT_URL non è definita, allora si sta cercando di manipolare il funzionamento del sistema
if (!defined('ROOT_URL')) {
    die;
}

// Se l'ID del prodotto non è specificato, reindirizza alla homepage
if (!isset($_GET['id'])) {
    echo "<script> location.href='" . ROOT_URL . "' </script>";
    exit;
}

// Se viene inviato il modulo per aggiungere al carrello
if (isset($_POST["add_to_cart"])) {
    $id_prodotto = htmlspecialchars($_POST['id_prod']);
    // Aggiungi al carrello
    $Cm = new ManagerCarrello();
    $id_carrello = $Cm->getIdCarrelloCorrente();
    $Cm->aggiungiAlCarrello($id_prodotto, $id_carrello);

    // Reindirizza alla pagina del carrello
    echo "<script> location.href='" . ROOT_URL .  "shop?page=carrello' </script>";
    exit;
}

// Ottieni il prodotto e le sue immagini
$id = htmlspecialchars_decode($_GET["id"]);
$pM = new ManagerProdotti();
$pI = new ManagerImg();
$product = $pM->getArticoloPublic($id);
$immagini = $pI->getImmaginiArticolo($id);

if (empty($product) || !array_key_exists('id', $product[0])) {
    echo "<script> location.href='" . ROOT_URL . "' </script>";
    exit;
}

function printCarousel($immagini) {
    if (!empty($immagini)) {
        ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                foreach ($immagini as $key => $immagine) {
                    $activeClass = ($key == 0) ? 'active' : '';
                    $img_path = ROOT_URL . $immagine['img_path'];
                    ?>
                    <div class="carousel-item <?php echo $activeClass; ?>">
                        <img src="<?php echo $img_path; ?>" class="d-block w-100 contain-image" alt="Immagine <?php echo $key + 1; ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Precedente</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Successivo</span>
            </button>
        </div>
        <?php
    }
}
?>

<a class="btn btn-outline-primary mb-3" href="<?php echo ROOT_URL; ?>shop?page=catalogo">
    <i class="fa-solid fa-arrow-left me-2"></i> Torna agli annunci
</a>

<div class="container px-4 px-lg-5 my-5">
    <div class="card shadow-lg border-0">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-lg-6">
                <div class="container" id="div_img" name="div_img">
                    <?php printCarousel($immagini); ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-body">
                    <a class="no-link" href="?page=profilo_venditore&id_seller=<?php echo $product[0]['id_seller']  ?>"> <div class="small mb-1 text-muted">Venditore: <?php echo $product[0]['username'] ?></div></a>
                    <h1 class="display-5 fw-bolder"><?php echo $product[0]['titolo'] ?></h1>
                    <div class="fs-5 mb-5 text-primary">
                        <span><?php echo $product[0]['prezzo'] ?> €</span>
                    </div>
                    <div class="d-flex mb-4">
                        <form method="post">
                            <input name="id_prod" id="id_prod" type="hidden" value="<?php echo $product[0]['id'] ?>">
                            <button class="btn btn-primary flex-shrink-0 me-2" name="add_to_cart" id="add_to_cart" type="submit">
                                Aggiungi al carrello
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                    <hr>
                    <h3>Descrizione:</h3>
                    <p class="lead"><?php echo $product[0]['descrizione'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Personalizzato -->
<style>
.carousel-item {
    text-align: center;
}

.contain-image {
    max-height: 500px;
    width: auto;
    height: auto;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto;
}

.back {
    display: inline-block;
    margin-bottom: 20px;
    text-decoration: none;
    color: #007bff;
}

.back:hover {
    text-decoration: underline;
    color: #0056b3;
}

.display-5 {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: bold;
}

.fs-5 {
    color: #333;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    padding: 10px;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}

@media (max-width: 767px) {
    .display-5 {
        font-size: 1.75rem;
    }
    .fs-5 {
        font-size: 1.25rem;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 10%;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        padding: 5px;
    }
}
</style>
