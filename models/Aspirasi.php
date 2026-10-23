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
  // ==========================================
// AMBIL SEMUA ASPIRASI UNTUK ADMIN
// ==========================================

public function getAll()
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
            a.admin_id,
            a.created_at,
            a.updated_at,
            s.nama_siswa,
            s.kelas,
            k.ket_kategori,
            ad.nama AS nama_admin
         FROM aspirasis a
         INNER JOIN siswas s
            ON a.nis = s.nis
         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori
         LEFT JOIN admins ad
            ON a.admin_id = ad.id
         ORDER BY a.created_at DESC"
    );

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


// ==========================================
// DETAIL ASPIRASI UNTUK ADMIN
// ==========================================

public function findByIdAdmin($id)
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
            a.admin_id,
            a.created_at,
            a.updated_at,
            s.nama_siswa,
            s.kelas,
            k.ket_kategori,
            ad.nama AS nama_admin
         FROM aspirasis a
         INNER JOIN siswas s
            ON a.nis = s.nis
         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori
         LEFT JOIN admins ad
            ON a.admin_id = ad.id
         WHERE a.id_aspirasi = ?
         LIMIT 1"
    );

    $query->execute([$id]);

    return $query->fetch(PDO::FETCH_ASSOC);
}


// ==========================================
// UPDATE STATUS DAN FEEDBACK
// ==========================================

public function updateStatusFeedback(
    $id,
    $status,
    $feedback,
    $adminId
) {
    $query = $this->db->prepare(
        "UPDATE aspirasis
         SET status = ?,
             feedback = ?,
             admin_id = ?,
             updated_at = NOW()
         WHERE id_aspirasi = ?"
    );

    return $query->execute([
        $status,
        $feedback,
        $adminId,
        $id
    ]);
}
  // ==========================================
// KATEGORI PENGADUAN BESERTA JUMLAHNYA
// ==========================================

public function getKategoriWithCount()
{
    $query = $this->db->prepare(
        "SELECT
            k.id_kategori,
            k.ket_kategori,
            COUNT(a.id_aspirasi) AS jumlah
         FROM kategoris k
         LEFT JOIN aspirasis a
            ON k.id_kategori = a.id_kategori
         GROUP BY
            k.id_kategori,
            k.ket_kategori
         ORDER BY k.ket_kategori ASC"
    );

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


// ==========================================
// ASPIRASI BERDASARKAN KATEGORI
// ==========================================

public function getByKategori($idKategori)
{
    $query = $this->db->prepare(
        "SELECT
            a.id_aspirasi,
            a.nis,
            a.ket,
            a.foto,
            a.anonim,
            a.status,
            a.feedback,
            a.created_at,
            s.nama_siswa,
            s.kelas,
            k.ket_kategori
         FROM aspirasis a
         INNER JOIN siswas s
            ON a.nis = s.nis
         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori
         WHERE a.id_kategori = ?
         ORDER BY a.created_at DESC"
    );

    $query->execute([$idKategori]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
  // ==========================================
// KATEGORI DENGAN JUMLAH STATUS TERTENTU
// ==========================================

public function getKategoriByStatus($status)
{
    $query = $this->db->prepare(
        "SELECT
            k.id_kategori,
            k.ket_kategori,
            COUNT(a.id_aspirasi) AS jumlah
         FROM kategoris k
         INNER JOIN aspirasis a
            ON k.id_kategori = a.id_kategori
         WHERE a.status = ?
         GROUP BY k.id_kategori, k.ket_kategori
         ORDER BY k.ket_kategori ASC"
    );

    $query->execute([$status]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


// ==========================================
// PENGADUAN PER KATEGORI DAN STATUS
// ==========================================

public function getByKategoriAndStatus($idKategori, $status)
{
    $query = $this->db->prepare(
        "SELECT
            a.id_aspirasi,
            a.ket,
            a.status,
            a.anonim,
            a.created_at,
            s.nama_siswa,
            s.kelas,
            k.ket_kategori
         FROM aspirasis a
         INNER JOIN siswas s ON a.nis = s.nis
         INNER JOIN kategoris k
            ON a.id_kategori = k.id_kategori
         WHERE a.id_kategori = ?
           AND a.status = ?
         ORDER BY a.created_at DESC"
    );

    $query->execute([$idKategori, $status]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
  // ==========================================
// REKAP JUMLAH PENGADUAN BERDASARKAN TANGGAL
// ==========================================

public function getRekapPengaduan($bulan, $tahun, $tanggal = null)
{
    $sql = "SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN status = 'Menunggu'
                    THEN 1 ELSE 0 END) AS menunggu,
                SUM(CASE WHEN status = 'Diproses'
                    THEN 1 ELSE 0 END) AS diproses,
                SUM(CASE WHEN status = 'Selesai'
                    THEN 1 ELSE 0 END) AS selesai
            FROM aspirasis
            WHERE MONTH(created_at) = ?
              AND YEAR(created_at) = ?";

    $params = [(int) $bulan, (int) $tahun];

    if ($tanggal !== null) {
        $sql .= " AND DAY(created_at) = ?";
        $params[] = (int) $tanggal;
    }

    $query = $this->db->prepare($sql);
    $query->execute($params);

    return $query->fetch(PDO::FETCH_ASSOC);
}


// ==========================================
// DAFTAR PENGADUAN BERDASARKAN PERIODE
// ==========================================

public function getPengaduanPeriode(
    $bulan,
    $tahun,
    $tanggal = null
) {
    $sql = "SELECT
                a.id_aspirasi,
                a.ket,
                a.status,
                a.anonim,
                a.created_at,
                s.nama_siswa,
                s.kelas,
                k.ket_kategori
            FROM aspirasis a
            INNER JOIN siswas s
                ON a.nis = s.nis
            INNER JOIN kategoris k
                ON a.id_kategori = k.id_kategori
            WHERE MONTH(a.created_at) = ?
              AND YEAR(a.created_at) = ?";

    $params = [(int) $bulan, (int) $tahun];

    if ($tanggal !== null) {
        $sql .= " AND DAY(a.created_at) = ?";
        $params[] = (int) $tanggal;
    }

    $sql .= " ORDER BY a.created_at DESC";

    $query = $this->db->prepare($sql);
    $query->execute($params);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
}