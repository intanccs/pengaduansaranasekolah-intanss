<?php

require_once __DIR__ . "/database.php";

class Aspirasi
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }


    // ==========================================
    // AMBIL SEMUA KATEGORI
    // ==========================================

    public function getKategori()
    {
        $query = $this->db->prepare(
            "SELECT id_kategori, ket_kategori
             FROM kategoris
             ORDER BY ket_kategori ASC"
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
  // ==========================================
// FEEDBACK SISWA
// ==========================================

public function getFeedbackByNis($nis)
{
    $query = $this->db->prepare(
        "SELECT
            a.id_aspirasi,
            a.lokasi,
            a.ket,
            a.foto,
            a.anonim,
            a.status,
            a.feedback,
            a.created_at,
            a.updated_at,
            k.ket_kategori
         FROM aspirasis a
         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori
         WHERE a.nis = ?
         AND a.feedback IS NOT NULL
         AND a.feedback != ''
         ORDER BY a.updated_at DESC"
    );

    $query->execute([$nis]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


    // ==========================================
    // MENGAMBIL HISTORI ASPIRASI SISWA
    // ==========================================

    public function getByNis($nis)
    {
        $query = $this->db->prepare(
            "SELECT
                a.id_aspirasi,
                a.status,
                a.lokasi,
                a.ket,
                a.foto,
                a.anonim,
                a.feedback,
                a.created_at,
                k.ket_kategori
             FROM aspirasis a
             INNER JOIN kategoris k
                ON a.id_kategori = k.id_kategori
             WHERE a.nis = ?
             ORDER BY a.created_at DESC"
        );

        $query->execute([$nis]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}