<?php

session_start();

require_once __DIR__ . "/../../controllers/AuthController.php";

$auth = new AuthController();

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nis = $_POST["nis"] ?? "";
    $nama = $_POST["nama"] ?? "";
    $kelas = $_POST["kelas"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";


    $result = $auth->registerSiswa(
        $nis,
        $nama,
        $kelas,
        $password,
        $confirmPassword
    );


    $message = $result["message"];


    if ($result["success"]) {

        $messageType = "success";

        $_SESSION["register_success"] =
            "Pendaftaran berhasil. Silakan login.";

        header("refresh:2;url=login.php");

    } else {

        $messageType = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register Siswa</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="auth-container">

    <div class="auth-box">

        <div class="auth-header">

            <div class="school-icon">
                🏫
            </div>

            <h1>
                Register Siswa
            </h1>

            <p>
                Buat akun untuk mengirim aspirasi sekolah
            </p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="input-group">

                <label>
                    NIS
                </label>

                <input
                    type="number"
                    name="nis"
                    required
                >

            </div>


            <div class="input-group">

                <label>
                    Nama Siswa
                </label>

                <input
                    type="text"
                    name="nama"
                    required
                >

            </div>


            <div class="input-group">

                <label>
                    Kelas
                </label>

                <input
                    type="text"
                    name="kelas"
                    placeholder="Contoh: XII RPL 1"
                    required
                >

            </div>


            <div class="input-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    minlength="6"
                    required
                >

            </div>


            <div class="input-group">

                <label>
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    minlength="6"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-primary"
            >
                Daftar
            </button>


            <p class="auth-switch">

                Sudah punya akun?

                <a href="login.php">
                    Login
                </a>

            </p>

        </form>

    </div>

</div>

</body>

</html>