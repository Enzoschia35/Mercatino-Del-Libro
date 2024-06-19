<?php

    class ManagerUtenti extends DBManager{



        public function __construct(){
            parent::__construct();//richiamo il costruttore della classe padre
            $this->columns = array('id','username',"email",'psw','nome','cognome','prefisso','numero_di_telefono','data_creazione','is_admin');
            $this->tableName = 'utenti';

        }  



       // Metodo login
       public function login($mail_user, $password){
        $stmt = $this->db->prepare("
            SELECT * 
            FROM utenti 
            WHERE 
            (email = :mail_user OR username = :mail_user) AND psw = :password
        ");

        $stmt->bindParam(':mail_user', $mail_user);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($res) > 0){
            $this->setUtente($res);
            return true;
        }

        return false;
    }

    private function setUtente($res){
        $user = (object) $res[0];
        
        $user = (object)[
            'id' => $user->id,
            'username' => $user->username,
            'is_admin' => $user->is_admin
        ];
            
        $_SESSION['user'] = $user;
    }

    public function passwordsMatch($password, $conferma_password){
        return $password == $conferma_password;
    }

    


        public function registrazione($nome,$cognome,$username,$email,$password,$prefisso,$telefono){
            
            $user_id = $this->create([
                'nome' => $nome,
                'cognome' => $cognome,
                'username' => $username,
                'email' => $email,
                'psw' => $password,
                'prefisso' => $prefisso,
                'numero_di_telefono' => $telefono,
                'data_creazione' => date("Y-m-d"),
                'is_admin' => false
            ]);

            return $user_id;
        }


        public function informazioniProfiloUtente($id)
        {
            return $this->get($id);
        }




    }





?>