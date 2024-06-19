<?php

    $usrMgr = new ManagerUtenti();
    $utenti = $usrMgr->getAll();

    $numero_utenti = (count($utenti) );
  
?>



<!-- ALERT -->
<?php if (isset($errMsg)) : ?>
  <div class="alert alert-success text-center" role="alert">
    <?php echo $errMsg; ?>
  </div>
<?php endif; ?>
<!--FINE ALERT-->

<p><a class="btn btn-primary rounded-1" href="<?php ROOT_URL; ?>?page=dashboard">Torna alla Dashboard</a></p>

    <div class="container">
            <h2 class="text-center mb-4">Utenti Registrati: <?php echo count($utenti) +1 ?></h2>
        

        <!-- ALERT -->
        <?php if (isset($errMsg)) : ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $errMsg; ?>
            </div>
        <?php endif; ?>
        <!-- FINE ALERT -->

       
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Utente</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Azione</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utenti as $utente) : ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($utente->id, ENT_QUOTES, 'UTF-8'); ?></th>
                            <td><?php echo htmlspecialchars($utente->username, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($utente->email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($utente->numero_di_telefono, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center">
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($utente->id, ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-success btn-sm" name="approva">Approva</button>
                                </form>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($utente->id, ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" name="no_approva">Non Approvare</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>