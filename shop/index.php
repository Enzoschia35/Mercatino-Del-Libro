
<?php

    $page = isset($_GET["page"]) ? $_GET["page"] : 'catalogo'; //reindirizzo le pagine dinamicamente tramite la query string
    //isset è un metodo php che restituisce un valore booleano controllando se page è settato quindi se è stato ricevuto un valore da query string
    // ? è un operatore ternario che nel caso il metodo isset restituisca true restituisce il risultato della query string altrimenti restituisce la pagina principale
    $_GET["page"] = 'catalogo';
?>

<?php include '../inizializzazione/init.php' ?> <!-- includo le costanti-->

<?php include ROOT_PATH . 'public/parti-template/header.php'?> 
<div id="main"class="container" style="margin-top: 50px;">
    <div class="row">

    
            <?php //include  ROOT_PATH . 'shop/parti-template/sidebar.php'?> 
            <div class="col-12">
                <?php include  ROOT_PATH . 'shop/pagine/' . $page . '.php'?> <!-- Riduco il codice utilizzando il risultato della query string-->
            </div>
            
        
      

    </div>
</div>

<?php include  ROOT_PATH . 'public/parti-template/footer.php'?> 
