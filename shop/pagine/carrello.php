  <?php

    $Cm = new ManagerCarrello();
    $id_carrello = $Cm->getIdCarrelloCorrente();

    

    if(isset($_POST['rimuovi_articolo']))
    {
      $id_libro = $_POST['id_libro'];
      $Cm->rimuoviDalCarrello($id_carrello,$id_libro);

    }

    if(isset($_POST['svuota_carrello']))
    {
      $Cm->svuotaCarrello($id_carrello);
    }

    $totale_carrello = $Cm->getTotaleCarrello($id_carrello);
    $elementi_carrello = $Cm->getElementiCarrello($id_carrello);

  ?>






<div class="col-12 order-md-2 mt-4 ">
  
<?php 
  
if(($totale_carrello['num_elementi']) > 0) : ?>
  <h4 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-black">Carrello</span>
    <span class="badge text-white rounded-pill bg-black "><?php echo $totale_carrello['num_elementi'];?> elementi nel carrello</span>
  </h4>
    
  
    <ul class="list-group mb-3">
      <?php foreach($elementi_carrello as  $elemento):  ?>
        <li class="list-group-item d-flex justify-content-between lh-condensed p-4">
          <div class="row w-100">

              <div class="col-lg-4 col-6">
              <a class="no-link" href="<?php ROOT_URL?>?page=vedi-prodotto&id=<?php  echo $elemento['id_libro']; ?>">
                <h6 title="Vedi annuncio" class="my-0"><?php echo substr($elemento['titolo'], 0, 30); ?>...&raquo;</h6>
              </a>

              <a class="no-link" href="<?php ROOT_URL?>?page=profilo_venditore&id=<?php  echo $elemento['id_venditore']; ?>" title="Informazioni venditore">
                <small class="text-muted"><?php echo $elemento['venditore']; ?></small>
              </a>

              </div>

              <!-- prezzo unitario articolo-->
              <div class="col-lg-4 col-6">
                  <span title="prezzo articolo" class="text-muted"><?php echo $elemento['prezzo'];?></span>
              </div>


              <!-- rimuovi-->
              <div class="col-lg-4 col-6">
                <form method="post">
                  <input type="hidden" name="id_libro" id="id_libro" value="<?php echo $elemento['id_libro'];?>">
                  <button title="Rimuovi articolo" name="rimuovi_articolo" id="rimuovi_articolo" class="button-icon">
                    <i class="fa-solid fa-delete-left"></i>
                  </button>
                </form>
              </div>

          </div>
          
        </li>
    <?php endforeach; ?>

      <!-- RIEPILOGO CARRELLO -->
      <li class="list-group-item d-flex justify-content-between p-4">
        <div class="row w-100">

            <div class="col-lg-4 col-6">
                <h6 class="my-0">TOTALE</h6>
            </div>

            <!-- DIV VUOTO PER ADATTARE A SCHERMO I VALORI -->
            <div class="col-lg-4 col-6">
              <strong title="totale carrello" class="text-black">$<?php echo $totale_carrello['prezzo_totale'];?></strong>

            </div>

            <!-- totale CARRELLO -->
            <div class="col-lg-2 col-6">
            <form method="post">
                  <input type="hidden" name="id_cart" id="id_cart" value="<?php echo $id_carrello;?>">
                  <button title="Svuota Carrello" name="svuota_carrello" id="svuota_carrello" class="button-icon">
                  <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
            </div>

        </div>
        
    </li>
    </ul>

    <form class="card p-2">
      <div class="input-group">
        <button type="submit" class="btn bg-black col-12 text-white">Ceckout</button>
      </div>
    </form>
  <?php else: ?>
    <div class="row ">
      <!-- Main Content -->
      
      <div class="col-sm-12 text-center empty-page mb-5">
          <i class="fa-solid fa-cart-arrow-down fa-7x"></i>
          <h2>Il tuo carrello è vuoto!</h2>
          <p class="mb-3 pb-1">Nessun elemento presente nel carrello.</p>
          <a href="<?php ROOT_URL?>?page=catalogo" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Torna agli annunci
          </a>
      </div>
      <!-- End Main Content -->
  </div>
  <?php endif; ?>

</div>
