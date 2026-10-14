<?php

require_once __DIR__ . "/../models/Aspirasi.php";

class AspirasiController
{
    private $aspirasi;

    public function __construct()
    {
        $this->aspirasi = new Aspirasi();
    }


    // ==========================================
    // KATEGORI
    // ==========================================

    public function getKategori()
    {
        return $this->aspirasi->getKategori();
    }


    // ==========================================
    // BUAT ASPIRASI
    // ==========================================

    public function buatAspirasi(
        $nis,
        $idKategori,
        $ket,
        $foto,
        $anonim
    ) {

        $ket = trim($ket);


        // Validasi kategori

        if (empty($idKategori)) {

            return [
                "success" => false,
                "message" => "Kategori wajib dipilih."
            ];
        }


    

        // Validasi keterangan

        if ($ket === "") {

            return [
                "success" => false,
                "message" => "Keterangan wajib diisi."
            ];
        }


        // Simpan

        $result = $this->aspirasi->create(
            $nis,
            $idKategori,       
            $ket,
            $foto,
            $anonim
        );


        if ($result) {

            return [
                "success" => true,
                "message" => "Aspirasi berhasil dikirim."
            ];
        }


        return [
            "success" => false,
            "message" => "Aspirasi gagal dikirim."
        ];
    }


    // ==========================================
    // HISTORI
    // ==========================================

    public function histori($nis)
    {
        return $this->aspirasi->getByNis($nis);
    }


    // ==========================================
    // FEEDBACK
    // ==========================================

    public function feedback($nis)
    {
        return $this->aspirasi->getFeedbackByNis($nis);
    }
  // ==========================================
// DAFTAR ASPIRASI ADMIN
// ==========================================

public function semuaAspirasi()
{
    return $this->aspirasi->getAll();
}


// ==========================================
// DETAIL ASPIRASI ADMIN
// ==========================================

public function detailAdmin($id)
{
    return $this->aspirasi->findByIdAdmin($id);
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
    $statusValid = [
        "Menunggu",
        "Diproses",
        "Selesai"
    ];

    if (!in_array($status, $statusValid, true)) {
        return [
            "success" => false,
            "message" => "Status tidak valid."
        ];
    }

    $feedback = trim($feedback);

    $result = $this->aspirasi->updateStatusFeedback(
        $id,
        $status,
        $feedback,
        $adminId
    );

    if ($result) {
        return [
            "success" => true,
            "message" => "Pengaduan berhasil diperbarui."
        ];
    }

    return [
        "success" => false,
        "message" => "Pengaduan gagal diperbarui."
    ];
}
  // ==========================================
// KATEGORI DAN JUMLAH PENGADUAN
// ==========================================

public function kategoriDenganJumlah()
{
    return $this->aspirasi->getKategoriWithCount();
}


// ==========================================
// DAFTAR PENGADUAN PER KATEGORI
// ==========================================

public function aspirasiPerKategori($idKategori)
{
    return $this->aspirasi->getByKategori($idKategori);
}
  public function kategoriBerdasarkanStatus($status)
{
    return $this->aspirasi->getKategoriByStatus($status);
}

public function daftarBerdasarkanKategoriDanStatus(
    $idKategori,
    $status
) {
    return $this->aspirasi->getByKategoriAndStatus(
        $idKategori,
        $status
    );
}
}