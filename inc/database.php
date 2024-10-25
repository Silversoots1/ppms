<?php
    Class Database
    {
        private $pdo;
        
        public function __construct()
        {
            $this->pdo = new PDO( "mysql:host=localhost;dbname=devel_silversoots","silversoots",'1234');
        }

        public function getPDO()
        {
            return $this->pdo;
        }

        public function terminatePDO(): void
        {
            $this->pdo = null;
        }

        public function readFromDatabase($sql)
        {
            
            $sth = $this->getPDO()->prepare($sql);
            $sth->execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function writeToDatabase($sql)
        {   
            $sth = $this->getPDO()->prepare($sql);
            $sth->execute();
        }
    }
?>