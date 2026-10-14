<?php
session_start();

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: ../auth/login.php");
    exit;
}

$nama = $_SESSION["admin_nama"] ?? "Admin";
$username = $_SESSION["admin_username"] ?? "-";
$jabatan = $_SESSION["admin_role"] ?? "-";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Admin</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="app">

    <header class="app-header">
        <a href="../dashboard/admin.php"
           style="color: inherit; text-decoration: none;">
            ←
        </a>

        <div class="app-title">Profil Admin</div>
    </header>

    <main class="content">

        <section class="profile-card">

            <div class="profile-avatar">👤</div>

            <h2><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></h2>

            <p class="admin-profile-role">
                <?= htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <div class="admin-profile-info">

                <div class="admin-profile-row">
                    <span>Nama Admin</span>
                    <strong><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="admin-profile-row">
                    <span>Username</span>
                    <strong><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="admin-profile-row">
                    <span>Jabatan</span>
                    <strong><?= htmlspecialchars($jabatan, ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

            </div>

            <a href="../dashboard/admin.php" class="admin-profile-button">
                Kembali ke Dashboard
            </a>

        </section>

    </main>

</div>

</body>
</html>