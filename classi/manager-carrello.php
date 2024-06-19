<?php

class ManagerCarrello extends DBManager {

    private $client_id;

    public function __construct() {
        parent::__construct(); // Richiama il costruttore della classe padre
        $this->columns = array('id', 'id_utente', 'data_creazione');
        $this->tableName = 'carrello';
        $this->carrelloUtenteLoggato();
    }

    private function carrelloUtenteLoggato() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']->id;
            $this->client_id = $user_id;

            // Controlla se l'utente ha un carrello associato
            $cart_id = $this->getIdCarrelloCorrente();

            if ($cart_id > 0) {
                // Aggiorna l'ID del carrello dell'utente nel database
                $this->updateUserCartId($user_id, $cart_id);
            }
        } else {
            $this->client_id = $this->inizializzaIdClienteFromSession();
            //echo "CLIENT ID: " . $this->client_id . "   "; 
        }
    }

    private function updateUserCartId($user_id, $cart_id) {
        // Questa funzione non è necessaria se l'ID del carrello è già associato all'utente nel carrello stesso
    }

    public function rimuoviDalCarrello($id_carrello, $id_prodotto) {
        $stmt = $this->db->prepare("SELECT id, quantita FROM articoli_carrello WHERE id_carrello = :id_carrello AND id_articolo = :id_prodotto");
        $stmt->bindParam(':id_carrello', $id_carrello, PDO::PARAM_INT);
        $stmt->bindParam(':id_prodotto', $id_prodotto, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0) {
            $id_elemento_carrello = $res[0]['id'];
            $CartItemMgr = new ManagerElementiCarrello();
            $CartItemMgr->delete($id_elemento_carrello);
        }
    }

    public function svuotaCarrello($id_carrello) {
        $stmt = $this->db->prepare("SELECT id, quantita FROM articoli_carrello WHERE id_carrello = :id_carrello");
        $stmt->bindParam(':id_carrello', $id_carrello, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $CartItemMgr = new ManagerElementiCarrello();
        foreach ($res as $elemento) {
            $CartItemMgr->delete($elemento['id']);
        }
    }

    public function getTotaleCarrello($id_carrello) {
        $stmt = $this->db->prepare("
            SELECT 
                SUM(quantita) AS num_elementi, 
                SUM(quantita * prezzo) AS prezzo_totale
            FROM articoli_carrello AS ac
                INNER JOIN libro AS l ON ac.id_articolo = l.id
            WHERE ac.id_carrello = :id_carrello
        ");
        $stmt->bindParam(':id_carrello', $id_carrello, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res;
    }

    public function getElementiCarrello($id_carrello) {
        $stmt = $this->db->prepare("
        SELECT 
            l.id AS id_libro,
            l.titolo,
            l.prezzo, 
            u.username AS venditore, 
            u.id AS id_venditore
        FROM articoli_carrello AS ac
            INNER JOIN libro AS l ON ac.id_articolo = l.id
            INNER JOIN utenti AS u ON l.id_utente = u.id
        WHERE ac.id_carrello = :id_carrello
        ");
        $stmt->bindParam(':id_carrello', $id_carrello, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdCarrelloCorrente() {
        $stmt = $this->db->prepare("SELECT id FROM carrello WHERE id_utente = :client_id");
        $stmt->bindParam(':client_id', $this->client_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0) {
           // echo "ID RITORNO QUERY >0: " . $res[0]['id'] . '  ';
            return $res[0]['id'];
        } else {
            // Se la query non restituisce righe, crea un nuovo carrello    
            $id_carrello = $this->create([
                'id_utente' => $this->client_id,
                'data_creazione' => date("Y-m-d")
            ]);

            //echo "ID RITORNO nuovo carrello: " . $id_carrello . '  ';
            return $id_carrello;
        }
    }

    public function aggiungiAlCarrello($id_prodotto, $id_carrello) {
        $stmt = $this->db->prepare("SELECT quantita FROM articoli_carrello WHERE id_carrello = :id_carrello AND id_articolo = :id_prodotto");
        $stmt->bindParam(':id_carrello', $id_carrello, PDO::PARAM_INT);
        $stmt->bindParam(':id_prodotto', $id_prodotto, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) <= 0) {
            $CartItemMgr = new ManagerElementiCarrello();
            $CartItemMgr->create([
                'id_carrello' => $id_carrello,
                'id_articolo' => $id_prodotto,
                'quantita' => 1
            ]);
        } else {
            echo "<script>alert('Articolo già presente nel carrello');</script>";
            // Redirect to cart page
            echo "<script>location.href='" . ROOT_URL . "shop?page=carrello'</script>";
            exit;
        }
    }

    private function inizializzaIdClienteFromSession() {
        if (isset($_SESSION['client_id'])) {
            return $_SESSION['client_id'];
        } else {
            // Genera una stringa casuale
            $stringa = $this->id_random();
            /*echo "ID GENERATO PRIMA: " . $stringa . "   ";

            if( $this->verificaPresenzaId($stringa)){
                echo"RISULTATO PRESENZA ID: ESISTE" . "   ";
            }else{
                echo"RISULTATO PRESENZA ID: NON ESISTE" . "   ";
            }*/

            
            while ($this->verificaPresenzaId($stringa)) {
                //echo"ESISTE QUINDI RIGENERO " . "   ";
                $stringa = $this->id_random();
                //echo"NUOVO ID: " . $stringa;
            }
           // echo "ID GENERATO FINALE: " . $stringa;
            // Imposta client_id in sessione con questa stringa
            $_SESSION['client_id'] = $stringa;

            //echo "ID SALVATO IN SESSIONE: " . $_SESSION['client_id'] . "   ";
            return $stringa;
        }
    }

    private function verificaPresenzaId($id_da_verificare) {
        $stmt = $this->db->prepare("SELECT id FROM carrello WHERE id_utente = :id_da_verificare");
        $stmt->bindParam(':id_da_verificare', $id_da_verificare, PDO::PARAM_STR); // Change to PARAM_STR for string IDs
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($res) > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    

    private function id_random() {
        // Definizione del range delle 10 cifre (da 1000000000 a 9999999999)
        $min = 1000000000;
        $max = 9999999999;
    
        // Generazione di un numero casuale nel range specificato
        return  random_int($min, $max);
    }
}

class ManagerElementiCarrello extends DBManager {

    public function __construct() {
        parent::__construct(); // Richiama il costruttore della classe padre
        $this->columns = array('id', 'id_carrello', 'id_articolo', 'quantita');
        $this->tableName = 'articoli_carrello';
    }
}