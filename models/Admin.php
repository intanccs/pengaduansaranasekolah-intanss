<?php

require_once __DIR__ . "/database.php";

class Admin
{
    private $db;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }


    // =========================
    // CARI ADMIN
    // =========================

    public function findByUsername($username)
    {
        $query = $this->db->prepare(
            "SELECT *
             FROM admins
             WHERE username = ?"
        );

        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}