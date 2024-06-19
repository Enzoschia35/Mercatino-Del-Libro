<?php include '../inizializzazione/init.php' ?> <!-- includo le costanti-->
<?php
    $page = isset($_GET["page"]) ? $_GET["page"] : 'login'; //reindirizzo le pagine dinamicamente tramite la query string
    //isset è un metodo php che restituisce un valore booleano controllando se page è settato quindi se è stato ricevuto un valore da query string
    // ? è un operatore ternario che nel caso il metodo isset restituisca true restituisce il risultato della query string altrimenti restituisce la pagina principale
    $_GET["page"] = 'login';
    
    if ($loggedInUser && $page != 'logout') {
      Header('Location: ' . ROOT_URL);
      exit;
    }

 ?>



<?php include ROOT_PATH . 'public/parti-template/header.php'?> <!-- Riduco il codice duplicato includendo il codice scritto nei file della cartella template parts -->
<div id="main"class="container" style="margin-top: 50px;">
    <div class="row">

        <div class="col-12">
            <?php include  ROOT_PATH . 'auth/pagine/' . $page . '.php'?> <!-- Riduco il codice utilizzando il risultato della query string-->
        </div>

        <?php include  ROOT_PATH . 'public/parti-template/sidebar.php'?> <!-- Riduco il codice duplicato includendo il codice scritto nei file della cartella template parts -->

    </div>
</div>

<?php include  ROOT_PATH . 'public/parti-template/footer.php'?> <!-- Riduco il codice duplicato includendo il codice scritto nei file della cartella template parts -->
