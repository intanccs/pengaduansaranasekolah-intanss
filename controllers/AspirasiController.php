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
}