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
// BUAT ASPIRASI
// ==========================================

public function create(
    $nis,
    $idKategori,
    $ket,
    $foto,
    $anonim
) {

    $query = $this->db->prepare(
        "INSERT INTO aspirasis
        (
            nis,
            id_kategori,
            ket,
            foto,
            anonim,
            status,
            feedback,
            admin_id,
            created_at,
            updated_at
        )
        VALUES
        (?, ?, ?, ?, ?, 'Menunggu', NULL, NULL, NOW(), NOW())"
    );

    return $query->execute([
        $nis,
        $idKategori,
        $ket,
        $foto,
        $anonim
    ]);
}

    // ==========================================
    // HISTORI ASPIRASI SISWA
    // ==========================================

    public function getByNis($nis)
{
    $query = $this->db->prepare(
        "SELECT
            a.id_aspirasi,
            a.status,
            s.kelas,
            a.ket,
            a.foto,
            a.anonim,
            a.feedback,
            a.created_at,
            k.ket_kategori
         FROM aspirasis a

         INNER JOIN siswas s
            ON a.nis = s.nis

         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori

         WHERE a.nis = ?

         ORDER BY a.created_at DESC"
    );

    $query->execute([$nis]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


    // ==========================================
    // DETAIL ASPIRASI
    // ==========================================

    public function findById($id, $nis)
    {
        $query = $this->db->prepare(
            "SELECT
                a.id_aspirasi,
                a.nis,
                a.id_kategori,
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
             WHERE a.id_aspirasi = ?
             AND a.nis = ?"
        );

        $query->execute([
            $id,
            $nis
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    // ==========================================
    // FEEDBACK SISWA
    // ==========================================

    public function getFeedbackByNis($nis)
    {
        $query = $this->db->prepare(
            "SELECT
                a.id_aspirasi,
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
}