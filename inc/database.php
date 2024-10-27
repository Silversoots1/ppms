<?php
    Class Database
    {
        private static $pdo;
        
        public function __construct()
        {
            self::createDatabaseConnection();
        }

        private static function createDatabaseConnection()
        {
            self::$pdo = new PDO( "mysql:host=localhost;dbname=devel_silversoots","silversoots",'');
        }

        public function getPDO()
        {
            return self::$pdo;
        }

        public function terminatePDO(): void
        {
            self::$pdo = null;
        }

        public function readFromDatabase($sql): array
        {
            
            $sth = self::getPDO()->prepare($sql);
            $sth->execute();

            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function writeToDatabase($sql): void
        {
            $sth = self::getPDO()->prepare($sql);
            $sth->execute();
        }
    }
?>