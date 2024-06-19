<?php

    class ManagerImg extends DBManager{
        
        public function __construct(){
            parent::__construct();//richiamo il costruttore della classe padre
            $this->columns = array('id','img_path','id_articolo',);
            $this->tableName = 'images';

        }  


        public function caricaImmagini($img_path,$id_articolo)
        {
            $res = $this->create([

                'img_path' => $img_path,
                'id_articolo' => $id_articolo

            ]);
            return $res;
        }


        public function getImmaginiArticolo($id_articolo)
        {              
            return $this->db->query("SELECT * FROM `images` where id_articolo = $id_articolo;");
           
        }



    }