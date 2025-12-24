<?php

class Database
{
    private $host = "mysql";
    private $username = "app_user";
    private $password = "secret";
    private $dbname = "GIGA_LEAGUE_DB";

    protected function connect()
    {
        try{

            $dataSourceName = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $pdo = new PDO($dataSourceName, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }catch(PDOException $e){
             die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
