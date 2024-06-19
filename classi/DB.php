<?php

    class DB{

        private $conn;
    private $pdo;

    // Costruttore
    public function __construct(){
        global $conn;
        $this->conn = $conn;
        if(mysqli_connect_errno()){
            echo 'Connessione a MySql fallita ' . mysqli_connect_error();
            die;
        }
        $this->pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Metodo per lanciare una query al database e prelevare il risultato
    public function query($sql){
        try {
            $q = $this->pdo->query($sql);
            if(!$q){
                throw new Exception("ERRORE DURANTE L'ESECUZIONE DELLA QUERY");
            }
            $data = $q->fetchAll();
            return $data;
        } catch(Exception $e) {
            throw $e;
        }
    }

    // Metodo per eseguire le query senza prelevare il risultato
    public function execute($sql){
        $stmt = $this->pdo->prepare($sql);  
        $stmt->execute();
    }

    // Metodo per preparare una query
    public function prepare($sql){
        return $this->pdo->prepare($sql);
    }

    // Metodi di proiezione, cancellazione, aggiornamento, inserimento (come definiti in precedenza)



        //proiezione
        //tableName indica la tabella da cui si vogliono prelevare i dati
        //columns è un array che conterrà tutti i campi selezionati es: id,nome...
        //restituisce una tabella usando SELECT
        public function select_all($tableName, $columns = array())
        {
            $query = 'SELECT';
            $strCol ='';
        
            foreach($columns as $colName)
            {
                $strCol .= ' ' . esc($colName) . ',';
            }
            $strCol = substr($strCol,0,-1);
            $query .= $strCol . ' FROM ' . $tableName;
        
            $result = mysqli_query($this->conn, $query);
        
            if (!$result) {
                // Query execution failed, handle the error as needed
                echo "Query execution failed: " . mysqli_error($this->conn);
                return false;
            }
        
            $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
            mysqli_free_result($result);
        
            return $resultArray;
        }

        public function select_all_where($tableName, $columns = array(), $condizione) {
            $query = 'SELECT ';
            $strCol = '';
    
            foreach ($columns as $colName) {
                $strCol .= esc($colName) . ', ';
            }
            $strCol = rtrim($strCol, ', ');
    
            $query .= $strCol . ' FROM ' . esc($tableName) . ' WHERE ' . $condizione;
            $query .= " AND i.id = (
                SELECT MIN(i2.id)
                FROM images AS i2
                WHERE i2.id_articolo = l.id
            );";

            // Stampa la query per debug
            echo "Query: " . $query . "<br>";
    
            $result = mysqli_query($this->conn, $query);
    
            if (!$result) {
                echo "Query execution failed: " . mysqli_error($this->conn);
                return false;
            }
    
            $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
            mysqli_free_result($result);
    
            return $resultArray;
        }
        
        
        


        //proiezione
        //tableName indica la tabella da cui si vogliono prelevare i dati
        //columns è un array che conterrà tutti i campi selezionati es: id,nome...
        //restituisce una tabella usando SELECT aggiungendo una WHERE per id
        public function select_one($tableName, $columns = array(), $id)
        {
            $strCol ='';

            foreach($columns as $colName)
            {
                $colName = esc($colName);
                $strCol .= ' ' . $colName . ',';
            }
            $strCol = substr($strCol,0,-1);
            $id = esc($id);
            $query = "SELECT $strCol FROM $tableName WHERE id = $id"; //la where funziona per le colonne di nome id 
                                                                    //seleziona tutti i campi passati nell'array
            $result = mysqli_query($this->conn,$query);
            $resultArray = mysqli_fetch_assoc($result);

            mysqli_free_result($result);
            return $resultArray;



        }

        public function delete_one($tableName, $id)
        {
            $id = esc($id);
            $query = "DELETE FROM $tableName WHERE id = $id";
            if(mysqli_query($this->conn,$query))
            {
                $rowsAffected = mysqli_affected_rows($this->conn);
                return $rowsAffected;
            }
            else {
                return -1;
            }
        

        }


        public function update_one($tableName,$columns = array(),$id)
        {
            $id = esc($id);
            $strCol = '';
            foreach($columns as $colName => $colValue)
            {
                $colName = esc($colName);
                $strCol .= " " . $colName . " = '$colValue' ,";
            }
            $strCol .= substr($strCol,0,-1);
            
            $query = "UPDATE $tableName SET $strCol WHERE id = $id";
            $query = str_replace("'NULL'","NULL", $query);

            if(mysqli_query($this->conn,$query))
            {
                $rowsAffected = mysqli_affected_rows($this->conn);
                return $rowsAffected;

            }
            else
            {
                return -1;
            }

            
        }
        

        public function insert_one($tableName, $columns = array())
        {
            $colNames = array();
            $colValues = array();

            foreach ($columns as $colName => $colValue)
            {
                $colNames[] = esc($colName);
                $colValues[] = "'" . esc($colValue) . "'";
            }

            $strCol = implode(', ', $colNames);
            $strColValues = implode(', ', $colValues);

            $query = "INSERT INTO $tableName ($strCol) VALUES ($strColValues)";

            if(mysqli_query($this->conn, $query))
            {
                $lastId = mysqli_insert_id($this->conn);
                return $lastId;
            }
            else
            {
                echo 'Errore durante l\'esecuzione della query: ' . mysqli_error($this->conn);
                return -1;
            }
        }
    }

    class DBManager {

        protected $db;
        protected $columns;
        protected $tableName;

        public function __construct(){
            $this->db = new DB();
        }

        //
        public function get($id){

            $resultArr = $this->db->select_one($this->tableName,$this->columns,(int)$id);
            return (object)$resultArr;
        }

        public function getAll(){

            $results = $this->db->select_all($this->tableName, $this->columns);
            $objects = array();
            foreach($results as $results)
            {
                array_push($objects,(object)$results);
            }
            return $objects;
        }

        public function getRecordFiltrati($condizione){


            $results = $this->db->select_all_where($this->tableName, $this->columns,$condizione);
            $objects = array();
            foreach($results as $results)
            {
                array_push($objects,(object)$results);
            }
            return $objects;
        }

        public function create($obj){
            
            $newId = $this->db->insert_one($this->tableName,(array)$obj);
            return $newId;
        }

        public function delete($id){
            $rowsDeleted = $this->db->delete_one($this->tableName,(int)$id);
            return (int) $rowsDeleted;
        }
        public function update($obj, $id){
            $rowsUpdated = $this->db->update_one($this->tableName,(array)$obj,(int) $id);
            return (int) $rowsUpdated;
        }
    }

?>