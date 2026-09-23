<?php

session_start();

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["role"] !== "siswa"
) {

    header(
        "Location: ../auth/login.php"
    );

    exit;
}

$nama =
    $_SESSION["nama_siswa"];

$nis =
    $_SESSION["nis"];

$kelas =
    $_SESSION["kelas"];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Siswa</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="app">


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

            Pengaduan Sarana Sekolah

        </div>


        <div class="profile-icon">

            👤

        </div>

    </header>


    <!-- OVERLAY -->

    <div
        id="overlay"
        class="overlay"
        
    ></div>


    <!-- MENU SAMPING -->

    <nav
        id="sideMenu"
        class="side-menu"
    >

        <div class="menu-header">

            <span>
                Menu
            </span>

            <button
                type="button"
                id="closeMenu"
              aria-label="Tutup menu"
            >
                ×
            </button>

        </div>


        <a href="siswa.php">
            🏠 Dashboard
        </a>

        <a href="#">
            📝 Buat Aspirasi
        </a>

        <a href="#">
            📋 Histori Aspirasi
        </a>

        <a href="#">
            💬 Umpan Balik
        </a>

        <a
            href="../../logout.php"
            class="menu-logout"
        >
            Keluar
        </a>

    </nav>


    <main class="content">

        <div class="welcome-card">

            <div>

                <div class="small-text">
                    Selamat datang
                </div>

                <h1>
                    <?= htmlspecialchars($nama) ?>
                </h1>

                <p>
                    NIS: <?= htmlspecialchars($nis) ?>
                    <br>
                    Kelas: <?= htmlspecialchars($kelas) ?>
                </p>

            </div>


            <div class="welcome-icon">
                🏫
            </div>

        </div>


        <h2 class="section-title">
            Menu Utama
        </h2>


      

            <a
    href="../aspirasi/buat.php"
    class="feature-card"
>

                <div class="feature-icon">
                    📝
                </div>

                <div>

                    <h3>
                        Buat Aspirasi
                    </h3>

                    <p>
                        Laporkan masalah sarana sekolah.
                    </p>

                </div>

            </a>


            <a href="histori.php" class="feature-card">

    <div class="feature-icon">
        📋
    </div>

    <div>

        <h3>
            Histori Aspirasi
        </h3>

        <p>
            Lihat riwayat laporan kamu.
        </p>

    </div>

</a>



            <a
                href="../feedback/index.php"
                class="feature-card"
            >

                <div class="feature-card">
                    💬
                </div>

                <div>

                    <h3>
                        Umpan Balik
                    </h3>

                    <p>
                        Lihat tanggapan dari sekolah.
                    </p>

                </div>

            </a>

        </div>

    </main>

</div>


<script src="../../assets/js/menu.js"></script>

</body>

</html>