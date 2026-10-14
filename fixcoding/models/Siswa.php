<?php

require_once __DIR__ . "/database.php";

class Siswa
{
    private $db;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();
    }


    // =========================
    // CARI SISWA BERDASARKAN NIS
    // =========================

    public function findByNis($nis)
    {
        $query = $this->db->prepare(
            "SELECT *
             FROM siswas
             WHERE nis = ?"
        );

        $query->execute([$nis]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    // =========================
    // REGISTER SISWA
    // =========================

    public function register(
        $nis,
        $nama,
        $kelas,
        $password
    ) {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = $this->db->prepare(
            "INSERT INTO siswas
            (nis, nama_siswa, kelas, password, created_at, updated_at)
            VALUES (?, ?, ?, ?, NOW(), NOW())"
        );

        return $query->execute([
            $nis,
            $nama,
            $kelas,
            $hashedPassword
        ]);
    }
}