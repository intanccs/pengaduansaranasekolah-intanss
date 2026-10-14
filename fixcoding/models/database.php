<?php

class Database
{
    private $host = "127.0.0.1";
    private $port = "3306";
    private $dbname = "saranasekolah";
    private $username = "root";
    private $password = "root";

    public function connect()
    {
        try {

            $pdo = new PDO(
                "mysql:host=" . $this->host .
                ";port=" . $this->port .
                ";dbname=" . $this->dbname .
                ";charset=utf8mb4",

                $this->username,
                $this->password
            );

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $pdo;

        } catch (PDOException $e) {

            die(
                "Koneksi database gagal!<br>" .
                "Error: " . $e->getMessage()
            );
        }
    }
}