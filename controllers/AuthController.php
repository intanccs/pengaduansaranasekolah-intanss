<?php

require_once __DIR__ . "/../models/Siswa.php";
require_once __DIR__ . "/../models/Admin.php";

class AuthController
{
    private $siswa;
    private $admin;


    public function __construct()
    {
        $this->siswa = new Siswa();
        $this->admin = new Admin();
    }


    // ==================================================
    // REGISTER SISWA
    // ==================================================

    public function registerSiswa(
        $nis,
        $nama,
        $kelas,
        $password,
        $confirmPassword
    ) {

        $nis = trim($nis);
        $nama = trim($nama);
        $kelas = trim($kelas);


        // NIS wajib angka
        if (!ctype_digit($nis)) {

            return [
                "success" => false,
                "message" => "NIS harus berupa angka."
            ];
        }


        // Nama wajib diisi
        if ($nama === "") {

            return [
                "success" => false,
                "message" => "Nama siswa wajib diisi."
            ];
        }


        // Kelas wajib diisi
        if ($kelas === "") {

            return [
                "success" => false,
                "message" => "Kelas wajib diisi."
            ];
        }


        // Password
        if (strlen($password) < 6) {

            return [
                "success" => false,
                "message" => "Password minimal 6 karakter."
            ];
        }


        // Konfirmasi password
        if ($password !== $confirmPassword) {

            return [
                "success" => false,
                "message" => "Konfirmasi password tidak sama."
            ];
        }


        // Cek NIS
        $existing = $this->siswa->findByNis($nis);

        if ($existing) {

            return [
                "success" => false,
                "message" => "NIS sudah terdaftar."
            ];
        }


        // Simpan siswa
        $this->siswa->register(
            $nis,
            $nama,
            $kelas,
            $password
        );


        return [
            "success" => true,
            "message" => "Pendaftaran berhasil."
        ];
    }


    // ==================================================
    // LOGIN SISWA
    // ==================================================

    public function loginSiswa(
        $nis,
        $password
    ) {

        $nis = trim($nis);

        $siswa = $this->siswa->findByNis($nis);


        if (!$siswa) {

            return [
                "success" => false,
                "message" => "NIS atau password salah."
            ];
        }


        if (!password_verify(
            $password,
            $siswa["password"]
        )) {

            return [
                "success" => false,
                "message" => "NIS atau password salah."
            ];
        }


        // Session siswa
        $_SESSION["login"] = true;

        $_SESSION["role"] = "siswa";

        $_SESSION["nis"] =
            $siswa["nis"];

        $_SESSION["nama_siswa"] =
            $siswa["nama_siswa"];

        $_SESSION["kelas"] =
            $siswa["kelas"];


        return [
            "success" => true,
            "message" => "Login siswa berhasil."
        ];
    }


    // ==================================================
    // LOGIN ADMIN
    // ==================================================

    public function loginAdmin(
        $username,
        $password
    ) {

        $username = trim($username);

        $admin =
            $this->admin->findByUsername($username);


        if (!$admin) {

            return [
                "success" => false,
                "message" => "Username atau password salah."
            ];
        }


        if (!password_verify(
            $password,
            $admin["password"]
        )) {

            return [
                "success" => false,
                "message" => "Username atau password salah."
            ];
        }


        // Session admin
        $_SESSION["login"] = true;

        $_SESSION["role"] = "admin";

        $_SESSION["admin_id"] =
            $admin["id"];

        $_SESSION["admin_username"] =
            $admin["username"];

        $_SESSION["admin_nama"] =
            $admin["nama"];

        $_SESSION["admin_role"] =
            $admin["role"];


        return [
            "success" => true,
            "message" => "Login admin berhasil."
        ];
    }
}