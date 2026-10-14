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
$jabatan = $_SESSION["admin_role"] ?? "Admin";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Admin</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >
</head>

<body>

<div class="app">

    <!-- HEADER -->

    <header class="app-header">

        <button
            type="button"
            id="menuButton"
            class="menu-button"
            aria-label="Buka menu"
        >
            ☰
        </button>

        <div class="app-title">
            Dashboard Admin
        </div>

    </header>


    <!-- OVERLAY -->

    <div
        id="overlay"
        class="overlay"
    ></div>


    <!-- SIDEBAR -->

    <nav
        id="sideMenu"
        class="side-menu"
    >

        <div class="menu-header">

            <span>Menu Admin</span>

            <button
                type="button"
                id="closeMenu"
                aria-label="Tutup menu"
            >
                ×
            </button>

        </div>

        <a href="admin.php">
            🏠 Dashboard
        </a>

        <a href="../aspirasi/index.php">
            📋 Kelola Pengaduan
        </a>

        <a href="../profil/admin.php">
            👤 Profil
        </a>

        <a
            href="../../logout.php"
            class="menu-logout"
        >
            🚪 Keluar
        </a>

    </nav>


    <!-- KONTEN -->

    <main class="content">

        <section class="admin-welcome">

            <div>

                <p class="admin-small-text">
                    Selamat datang,
                </p>

                <h1>
                    <?= htmlspecialchars($nama) ?>
                </h1>

                <p class="admin-role">
                    <?= htmlspecialchars($jabatan) ?>
                </p>

            </div>

            <div class="admin-welcome-icon">
                🏫
            </div>

        </section>


        <h2 class="section-title">
            Ringkasan Pengaduan
        </h2>


        <!-- STATISTIK -->

        <section class="admin-stat-grid">

            <a href="../aspirasi/index.php"
   class="admin-stat-card"
   style="display:block; text-decoration:none; color:inherit;">

    <div class="admin-stat-icon">
        📋
    </div>

    <h3>Semua Pengaduan</h3>

    <p>
        Lihat seluruh laporan siswa.
    </p>

            </a>

            <a href="../aspirasi/menunggu.php"
   class="admin-stat-card"
   style="display:block;text-decoration:none;color:inherit;">

    <div class="admin-stat-icon">🕒</div>
    <h3>Menunggu</h3>
    <p>Lihat pengaduan yang belum diproses.</p>

            </a>

            <a href="../aspirasi/proses.php"
   class="admin-stat-card"
   style="display:block;text-decoration:none;color:inherit;">

    <div class="admin-stat-icon">🔧</div>

    <h3>Dalam Proses</h3>

    <p>Lihat pengaduan yang sedang ditangani.</p>

            </a>


            <a href="../aspirasi/selesai.php" class="admin-stat-card">

                <div class="admin-stat-icon">
                    ✅
                </div>

                <h3>Selesai</h3>

                <p>
                    Laporan yang telah diselesaikan.
                </p>

            </a>

        </section>



    </main>

</div>

<script src="../../assets/js/menu.js"></script>

</body>
</html>