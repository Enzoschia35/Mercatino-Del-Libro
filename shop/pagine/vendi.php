<?php
$errMsg = null;

if(isset($_POST['carica_libro'])) {

    $titolo = isset($_POST['titolo']) ? $_POST['titolo'] : '';
    $autore = isset($_POST['autore']) ? $_POST['autore'] : 'non specificato';
    $editore = isset($_POST['editore']) ? $_POST['editore'] : 'non specificato';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
    $condizioni = isset($_POST['condizioni']) ? $_POST['condizioni'] : '';
    $prezzo = isset($_POST['prezzo']) ? $_POST['prezzo'] : '';
    $materia = isset($_POST['materia']) ? $_POST['materia'] : 'non specificato';
    $descrizione = isset($_POST['descrizione']) ? $_POST['descrizione'] : '';
    $id_utente = isset($_POST['id_utente']) ? $_POST['id_utente'] : '';

    $prdMgr = new ManagerProdotti();
    $res = $prdMgr->aggiungiArticolo($titolo,$isbn,$prezzo,$condizioni,$descrizione,$autore,$editore,$materia,$id_utente);
    if($res) {
        // Reindirizzamento immediato dopo login
        $id_articolo = $res;
        $errMsg = 'Complimenti! Hai inserito correttamente tutte le informazioni. Il tuo annuncio è in fase di revisione';

        if(isset($_FILES['fileToUpload'])) {
            $file_array = reArrayFiles($_FILES['fileToUpload']);

            foreach ($file_array as $file) {
                $file_name = $file['name'];
                $file_tmp_name = $file['tmp_name'];
                $file_size = $file['size'];
                $file_error = $file['error'];

                // Controlla se non ci sono errori durante il caricamento
                if ($file_error === 0) {
                    // Move il file nella tua directory desiderata
                    $file_destination = 'C:\xampp\htdocs\mercatino_libro_online\images\web\\' . $file_name;
                    move_uploaded_file($file_tmp_name, $file_destination);

                    $file_destination = '\images\web\\' . $file_name;
                    // Salva il percorso del file nel database
                    $imgMgr = new ManagerImg();
                    $imgMgr->caricaImmagini($file_destination, $id_articolo);
                } else {
                    $errMsg = "Si è verificato un errore durante il caricamento del file.";
                }
            }
        }
    } else {
        $errMsg = 'Registrazione Fallita...';
    }
}

//funzione riordinamento array
function reArrayFiles($file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
?>

<style>
    .drop-area {
        border: 2px dashed #007bff;
        padding: 30px;
        width: 100%;
        text-align: center;
        cursor: pointer;
        background-color: #f8f9fa;
        transition: background-color 0.3s;
    }
    .drop-area:hover {
        background-color: #e2e6ea;
    }
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
    }
    .preview-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin-right: 10px;
        margin-bottom: 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    .dragover {
    border-color: green; /* Modifica il colore del bordo durante il trascinamento */
    background-color: rgba(0, 255, 0, 0.1); /* Modifica il colore dello sfondo durante il trascinamento */
    }
</style>


<!-- ALERT -->
<?php if(isset($errMsg)) : ?>
  <div class="alert alert-success text-center" role="alert">
    <?php echo $errMsg; ?>
  </div>

<?php endif; ?>
<!--FINE ALERT-->


<div class="container my-5">
    <?php if(isset($loggedInUser)): ?>
    <div class="card">
        <div class="card-header">
            <h3>Carica le immagini del libro</h3>
            <h6>[Min 1 - Max 4 foto]</h6>
        </div>
        <div class="card-body">
            <form id="bookForm" method="post" enctype="multipart/form-data">
                <!-- Caricamento immagini -->
                <div class="preview-container"></div>
                <div class="drop-area mb-3" id="fileDropArea">
                    Trascina e rilascia le immagini qui oppure clicca per selezionarle.
                </div>
                <input type="file" name="fileToUpload[]" id="fileToUpload" multiple class="form-control d-none" required>
                <hr>
                <!-- Inserisci le informazioni del libro -->
                <div class="mb-3">
                    <label for="titolo" class="form-label">Titolo</label>
                    <input type="text" name="titolo" id="titolo" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="autore" class="form-label">Autore</label>
                        <input type="text" name="autore" id="autore" class="form-control" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="editore" class="form-label">Editore</label>
                        <input type="text" name="editore" id="editore" class="form-control" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="isbn" class="form-label">Codice ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="form-control" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="condizioni" class="form-label">Condizioni</label>
                        <select id="condizioni" name="condizioni" class="form-select" required>
                            <option value="">Seleziona lo stato del tuo articolo:</option>
                            <option value="Nuovo">Nuovo</option>
                            <option value="Come Nuovo">Come Nuovo</option>
                            <option value="Ottime Condizioni">Ottime Condizioni</option>
                            <option value="Buone Condizioni">Buone Condizioni</option>
                            <option value="Condizioni Scadenti">Condizioni Scadenti</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prezzo" class="form-label">Prezzo</label>
                        <div class="input-group">
                            <input type="number" min="1" step="any" name="prezzo" id="prezzo" class="form-control" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="materia" class="form-label">Materia</label>
                    <input type="text" id="materia" name="materia" class="form-control">
                </div>
                <hr>
                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione articolo [Max 300 caratteri]</label>
                    <textarea class="form-control" id="descrizione" name="descrizione" maxlength="300"></textarea>
                </div>
                <input type="hidden" name="id_utente" id="id_utente" value="<?php  echo  $loggedInUser->id;?>">
                <button type="submit" class="btn btn-primary col-12" name="carica_libro">Carica</button>
            </form>
        </div>
    </div>
    <?php endif;?>

    <?php if(!isset($loggedInUser)): ?>
        <div class="text-center">
            <h2>Ciao!</h2>
            <h3>Sembra che tu non abbia ancora effettuato l'accesso <i class="fa-regular fa-face-sad-tear"></i></h3>
            <strong><p>Per iniziare a vendere, effettua prima il login.</p></strong>
            <a href="<?php echo ROOT_URL; ?>auth?page=login" class="btn btn-primary"> Effettua il login <i class="fas fa-sign-in-alt"></i></a>
        </div>
    <?php endif;?>
    
       
</div>

<script>
    document.getElementById("fileDropArea").addEventListener("click", function() {
        document.getElementById("fileToUpload").click();
    });

    document.getElementById("bookForm").addEventListener("submit", function(event) {
        var files = document.getElementById("fileToUpload").files;
        var allowedTypes = ["image/jpeg", "image/png"];
        var maxFileSize = 5 * 1024 * 1024; // 5 MB
        var maxFiles = 4;
        var totalFileSize = 0;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!allowedTypes.includes(file.type)) {
                alert("Tipo di file non supportato per il file '" + file.name + "'. Sono supportati solo file JPG e PNG");
                event.preventDefault();
                return;
            }
            totalFileSize += file.size;
            if (file.size > maxFileSize) {
                alert("Dimensioni del file '" + file.name + "' superiori a 5MB.");
                event.preventDefault();
                return;
            }
        }

        if (files.length > maxFiles) {
            alert("Puoi caricare al massimo 4 immagini.");
            event.preventDefault();
            return;
        }

        if (totalFileSize > maxFileSize * maxFiles) {
            alert("La dimensione totale dei file supera il limite consentito.");
            event.preventDefault();
            return;
        }
    });

    document.getElementById("fileToUpload").addEventListener("change", function(event) {
        var previewContainer = document.querySelector(".preview-container");
        previewContainer.innerHTML = ""; // Cancella le anteprime precedenti

        var files = event.target.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.type.match("image.*")) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = document.createElement("img");
                    img.src = event.target.result;
                    img.classList.add("preview-image");
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
</script>

<!-- DROP AREA -->
<script>
    document.getElementById("fileDropArea").addEventListener("dragover", function(event) {
        event.preventDefault();
        this.classList.add('dragover');
    });

    document.getElementById("fileDropArea").addEventListener("dragleave", function(event) {
        this.classList.remove('dragover');
    });

    document.getElementById("fileDropArea").addEventListener("drop", function(event) {
        event.preventDefault();
        this.classList.remove('dragover');
        var files = event.dataTransfer.files;
        document.getElementById("fileToUpload").files = files;

        var previewContainer = document.querySelector(".preview-container");
        previewContainer.innerHTML = ""; // Cancella le anteprime precedenti

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (file.type.match("image.*")) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var img = document.createElement("img");
                    img.src = event.target.result;
                    img.classList.add("preview-image");
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
</script>
