<?php

session_start();

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "siswa"
) {
    header("Location: ../auth/login.php");
    exit;
}

$nama = $_SESSION["nama_siswa"];
$nis = $_SESSION["nis"];
$kelas = $_SESSION["kelas"];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Profil Siswa</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="app">

    <!-- HEADER -->

    <header class="app-header">

        <a
            href="../dashboard/siswa.php"
            class="back-button"
        >
            ←
        </a>

        <div class="app-title">
            Profil Siswa
        </div>

    </header>


    <!-- CONTENT -->

    <main class="content">

        <div class="student-profile-card">

            <!-- AVATAR -->

            <div class="student-profile-avatar">
                👤
            </div>


            <!-- NAMA -->

            <h1 class="student-profile-name">
                <?= htmlspecialchars($nama) ?>
            </h1>


            <!-- ROLE -->

            <p class="student-profile-role">
                Siswa
            </p>


            <!-- DATA -->

            <div class="student-profile-info">

                <div class="student-profile-item">

                    <span class="student-profile-label">
                        NIS
                    </span>

                    <span class="student-profile-value">
                        <?= htmlspecialchars($nis) ?>
                    </span>

                </div>


                <div class="student-profile-item">

                    <span class="student-profile-label">
                        Nama
                    </span>

                    <span class="student-profile-value">
                        <?= htmlspecialchars($nama) ?>
                    </span>

                </div>


                <div class="student-profile-item">

                    <span class="student-profile-label">
                        Kelas
                    </span>

                    <span class="student-profile-value">
                        <?= htmlspecialchars($kelas) ?>
                    </span>

                </div>

            </div>


            <!-- KEMBALI -->

            <a
                href="../dashboard/siswa.php"
                class="student-profile-back"
            >
                Kembali ke Dashboard
            </a>

        </div>

    </main>

</div>

</body>

</html>