<?php

session_start();

require_once __DIR__ . "/../../models/Aspirasi.php";


// ==========================================
// CEK LOGIN SISWA
// ==========================================

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "siswa"
) {
    header("Location: ../auth/login.php");
    exit;
}


// ==========================================
// DATA SISWA
// ==========================================

$nis = $_SESSION["nis"];
$nama = $_SESSION["nama_siswa"];


// ==========================================
// AMBIL HISTORI
// ==========================================

$aspirasiModel = new Aspirasi();

$histori = $aspirasiModel->getByNis($nis);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Histori Aspirasi</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="app">


    <!-- ==============================
         HEADER
    =============================== -->

    <header class="app-header">

        <a
            href="siswa.php"
            class="back-button"
        >
            ←
        </a>

        <div class="app-title">
            Histori Aspirasi
        </div>

        <div class="profile-icon">
            👤
        </div>

    </header>


    <!-- ==============================
         CONTENT
    =============================== -->

    <main class="content">

        <div class="history-header">

            <h1>Histori Aspirasi</h1>

            <p>
                Riwayat laporan yang pernah kamu kirim.
            </p>

        </div>


        <?php if (empty($histori)): ?>

            <!-- BELUM ADA ASPIRASI -->

            <div class="empty-history">

                <div class="empty-icon">
                    📋
                </div>

                <h2>
                    Belum ada aspirasi
                </h2>

                <p>
                    Kamu belum pernah mengirim laporan
                    sarana sekolah.
                </p>

                <a
                    href="#"
                    class="btn-primary"
                >
                    Buat Aspirasi
                </a>

            </div>


        <?php else: ?>


            <!-- ==============================
                 DAFTAR HISTORI
            =============================== -->

            <div class="history-list">

                <?php foreach ($histori as $item): ?>

                    <div class="history-card">


                        <!-- KATEGORI -->

                        <div class="history-top">

                            <span class="category">
                                <?php
                                echo htmlspecialchars(
                                    $item["ket_kategori"]
                                );
                                ?>
                            </span>


                            <!-- STATUS -->

                            <?php

                            $statusClass = "";

                            if ($item["status"] === "Menunggu") {
                                $statusClass = "waiting";
                            }

                            elseif ($item["status"] === "Proses") {
                                $statusClass = "process";
                            }

                            elseif ($item["status"] === "Selesai") {
                                $statusClass = "done";
                            }

                            ?>

                            <span
                                class="status <?php echo $statusClass; ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    $item["status"]
                                );
                                ?>
                            </span>

                        </div>


                        <!-- ISI LAPORAN -->

                        <h3>
                            <?php
                            echo htmlspecialchars(
                                $item["lokasi"]
                            );
                            ?>
                        </h3>


                        <p class="description">

                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $item["ket"]
                                )
                            );
                            ?>

                        </p>


                        <!-- FOTO -->

                        <?php if (!empty($item["foto"])): ?>

                            <img
                                src="../../assets/uploads/<?php
                                    echo htmlspecialchars(
                                        $item["foto"]
                                    );
                                ?>"
                                class="history-photo"
                                alt="Bukti aspirasi"
                            >

                        <?php endif; ?>


                        <!-- TANGGAL -->

                        <div class="history-date">

                            <?php

                            if (!empty($item["created_at"])) {

                                echo date(
                                    "d M Y, H:i",
                                    strtotime(
                                        $item["created_at"]
                                    )
                                );

                            }

                            ?>

                        </div>


                        <!-- FEEDBACK -->

                        <?php if (!empty($item["feedback"])): ?>

                            <div class="feedback-box">

                                <strong>
                                    Umpan Balik Sekolah
                                </strong>

                                <p>
                                    <?php
                                    echo nl2br(
                                        htmlspecialchars(
                                            $item["feedback"]
                                        )
                                    );
                                    ?>
                                </p>

                            </div>

                        <?php endif; ?>


                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


    </main>

</div>

</body>
</html>