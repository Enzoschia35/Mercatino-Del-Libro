<?php

$errMsg = null;
$pM = new ManagerProdotti();
$res = $pM->getArticoliDaApprovare();

if (isset($_POST['approva'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $pM->approvaOrNotAnnunncio($id,true);
    $errMsg = 'L\'annuncio ID: ' . $id . ' è stato approvato con successo';
}

if (isset($_POST['no_approva'])) {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $pM->approvaOrNotAnnunncio($id,false);
    $errMsg = 'L\'annuncio ID: ' . $id . ' non è stato approvato';
}
?>


<p><a class="btn btn-primary rounded-1" href="<?php ROOT_URL; ?>?page=dashboard">Torna alla Dashboard</a></p>
<div class="container">
        <div class="mb-4">
            <h2 class="text-center">Annunci da Approvare: <?php echo count($res); ?></h2>
        </div>

        <!-- ALERT -->
        <?php if ($errMsg) : ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $errMsg; ?>
            </div>
        <?php endif; ?>
        <!-- FINE ALERT -->

        
        <div class="table-responsive" >
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Annuncio</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col">ID Venditore</th>
                        <th scope="col">Azione</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res as $articolo) : ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($articolo['id'], ENT_QUOTES, 'UTF-8'); ?></th>
                            <td>
                                <?php echo htmlspecialchars($articolo['titolo'], ENT_QUOTES, 'UTF-8'); ?>
                                <a href="<?php echo ROOT_URL . 'shop?page=vedi-prodotto&id=' . htmlspecialchars($articolo['id'], ENT_QUOTES, 'UTF-8'); ?>" class="float-right">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($articolo['prezzo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($articolo['id_utente'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($articolo['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-success btn-sm" name="approva">Approva</button>
                                </form>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($articolo['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" name="no_approva">Non Approvare</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>