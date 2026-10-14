<?php

session_start();

require_once __DIR__ . "/../../controllers/AuthController.php";

$auth = new AuthController();

$message = "";
$messageType = "";

if (isset($_SESSION["register_success"])) {
    $message = $_SESSION["register_success"];
    $messageType = "success";

    unset($_SESSION["register_success"]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $identitas = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Coba login sebagai siswa terlebih dahulu.
    $result = $auth->loginSiswa(
        $identitas,
        $password
    );

    if ($result["success"]) {

        header("Location: ../dashboard/siswa.php");
        exit;

    }

    // Jika bukan akun siswa, coba sebagai admin.
    $result = $auth->loginAdmin(
        $identitas,
        $password
    );

    if ($result["success"]) {

        header("Location: ../dashboard/admin.php");
        exit;

    }

    $message = "Username atau password salah.";
    $messageType = "error";
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

    <title>Login</title>

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

            <h1>Login</h1>

            <p>Pengaduan Sarana Sekolah</p>

        </div>

        <?php if ($message !== ""): ?>

            <div class="message <?= htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="input-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan NIS atau username"
                    autocomplete="username"
                    required
                >

            </div>

            <div class="input-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn-primary"
            >
                Login
            </button>

            <p class="auth-switch">
                Belum punya akun?

                <a href="register.php">
                    Register
                </a>
            </p>

        </form>

    </div>

</div>

</body>
</html>