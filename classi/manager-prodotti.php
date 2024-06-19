<?php

    class ManagerProdotti extends DBManager{
        
        public function __construct(){
            parent::__construct();//richiamo il costruttore della classe padre
            $this->columns = array('id','titolo',"isbn",'prezzo','condizioni','descrizione','data_public','autore','editore','materia','id_utente','is_public');
            $this->tableName = 'libro';

        }  


        public function aggiungiArticolo( $titolo,$isbn,$prezzo,$condizioni,$descrizione,$autore,$editore,$materia,$id_utente)
        {   
            $bookid = $this->create([
                
                'titolo' => $titolo,
                'isbn' => $isbn,
                'prezzo'=> $prezzo,
                'condizioni' => $condizioni,
                'descrizione'=> $descrizione,
                'data_public'=> date("Y-m-d"),
                'autore' => $autore,
                'editore'=> $editore,
                'materia'=> $materia,
                'id_utente'=> $id_utente,
                'is_public'=> false
                
                //'stato'=> 'Disponibile',
                
                
            ]);
            return $bookid;
        }

        //ritorna risultato query annunci da approvare
        public function getArticoliDaApprovare(){

            return $this->db->query("
            SELECT * 
            FROM `libro` 
            WHERE is_public = false;");

        }
    
        
        //ritorna risultato query annunci da approvare
        public function getArticoliPubblici($offset, $limit){ 
            return $this->db->query("
                SELECT l.*,i.img_path, u.username,u.id as id_seller
                FROM libro as l 
                    INNER JOIN images as i on i.id_articolo = l.id 
                    INNER JOIN utenti as u on u.id = l.id_utente
                WHERE l.is_public = true
                AND i.id = (
                    SELECT MIN(i2.id)
                    FROM images AS i2
                    WHERE i2.id_articolo = l.id
                )
                LIMIT $offset, $limit ");
        }

        public function getArticoloPublic($id_prodotto){
            return $this->db->query("
            SELECT l.*, u.username,u.id as id_seller
            FROM libro as l 
                INNER JOIN utenti as u on u.id = l.id_utente
            WHERE l.id ='$id_prodotto'; ");
        }

        public function getAnnunciPublic(){
            return $this->db->query("
            SELECT l.*, u.username,u.id as id_seller
            FROM libro as l 
                INNER JOIN utenti as u on u.id = l.id_utente
            ; ");
        }
        
        public function approvaOrNotAnnunncio($id_prodotto,$true_false){
            $this->db->query("UPDATE libro SET is_public = '$true_false' WHERE id = '$id_prodotto' ");
            
            if($true_false )
            {    
                return true;
            }else{
                return false;
            }

            
        }
        
        public function contaArticoli()
        {
            return $this->db->query("SELECT COUNT(id) as conteggio FROM libro WHERE is_public = true");
        }

        public function getArticoliConCondizione($condizione)
        {
            return $this->db->select_all_where($this->tableName, $this->columns, $condizione);
        }


        public function getFilteredProducts($titolo = '', $prezzoMin = '', $prezzoMax = '', $condizioni = '' ) {
            $query = "
            SELECT count(l.id) as conteggio
            FROM libro as l 
            WHERE l.is_public = true ";
           
            $params = [];
            
            if (!empty($titolo)) {
                $query .= " AND titolo LIKE ?";
                $params[] = '%' . $titolo . '%';
            }
            
            if (!empty($prezzoMin)) {
                $query .= " AND prezzo >= ?";
                $params[] = $prezzoMin;
            }
    
            if (!empty($prezzoMax)) {
                $query .= " AND prezzo <= ?";
                $params[] = $prezzoMax;
            }
    
            if (!empty($condizioni) && $condizioni != 'Tutte') {
                $query .= " AND condizioni = ?";
                $params[] = $condizioni;
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getFilteredProductsPaginazione($titolo = '', $prezzoMin = '', $prezzoMax = '', $condizioni = '' , $offset, $limit) {
            $query = "
            SELECT l.*,i.img_path, u.username,u.id as id_seller
            FROM libro as l 
                INNER JOIN images as i on i.id_articolo = l.id 
                INNER JOIN utenti as u on u.id = l.id_utente
            WHERE l.is_public = true ";
           
            $params = [];
            
            if (!empty($titolo)) {
                $query .= " AND titolo LIKE ?";
                $params[] = '%' . $titolo . '%';
            }
            
            if (!empty($prezzoMin)) {
                $query .= " AND prezzo >= ?";
                $params[] = $prezzoMin;
            }
    
            if (!empty($prezzoMax)) {
                $query .= " AND prezzo <= ?";
                $params[] = $prezzoMax;
            }
    
            if (!empty($condizioni) && $condizioni != 'Tutte') {
                $query .= " AND condizioni = ?";
                $params[] = $condizioni;
            }
    
            $query .= " AND i.id = (
                SELECT MIN(i2.id)
                FROM images AS i2
                WHERE i2.id_articolo = l.id
            ) LIMIT $offset, $limit ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    

    