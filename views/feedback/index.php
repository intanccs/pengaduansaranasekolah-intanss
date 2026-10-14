<?php

session_start();


// ==========================================
// CEK LOGIN SISWA
// ==========================================

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["role"] !== "siswa"
) {
    header("Location: ../auth/login.php");
    exit;
}


// ==========================================
// PANGGIL CONTROLLER
// ==========================================

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();


// ==========================================
// AMBIL FEEDBACK SISWA
// ==========================================

$nis = $_SESSION["nis"];

$feedbackList = $controller->feedback($nis);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Umpan Balik</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="app">


    <!-- ==================================
         HEADER
    ================================== -->

    <header class="app-header">

        <a
            href="../dashboard/siswa.php"
            class="back-button"
        >
            ←
        </a>


        <div class="app-title">

            Umpan Balik

        </div>

    </header>


    <!-- ==================================
         CONTENT
    ================================== -->

    <main class="content">


        <h2 class="section-title">
            Umpan Balik Aspirasi
        </h2>


        <?php if (empty($feedbackList)): ?>

            <div class="empty-card">

                <div class="empty-icon">
                    💬
                </div>

                <h3>
                    Belum Ada Umpan Balik
                </h3>

                <p>
                    Belum ada aspirasi yang mendapatkan
                    umpan balik dari admin.
                </p>

            </div>


        <?php else: ?>


            <!-- ==================================
                 DAFTAR FEEDBACK
            ================================== -->

            <div class="feedback-list">


                <?php foreach ($feedbackList as $item): ?>


                    <div class="feedback-card">


                        <!-- KATEGORI -->

                        <div class="feedback-header">

                            <h3>

                                <?= htmlspecialchars(
                                    $item["ket_kategori"]
                                ) ?>

                            </h3>


                            <!-- STATUS -->

                            <?php

                            $statusClass = "";

                            if ($item["status"] === "Menunggu") {
                                $statusClass = "status-menunggu";
                            }

                            elseif ($item["status"] === "Proses") {
                                $statusClass = "status-proses";
                            }

                            elseif ($item["status"] === "Selesai") {
                                $statusClass = "status-selesai";
                            }

                            ?>


                            <span
                                class="status <?= $statusClass ?>"
                            >

                                <?= htmlspecialchars(
                                    $item["status"]
                                ) ?>

                            </span>

                        </div>


                        <!-- LOKASI -->

                        <p class="feedback-location">

                            📍

                            <?= htmlspecialchars(
                                $item["lokasi"]
                            ) ?>

                        </p>


                        <!-- KETERANGAN -->

                        <div class="feedback-section">

                            <strong>
                                Keterangan
                            </strong>

                            <p>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $item["ket"]
                                    )
                                ) ?>

                            </p>

                        </div>


                        <!-- FEEDBACK ADMIN -->

                        <div class="admin-feedback">

                            <strong>
                                Umpan Balik Admin
                            </strong>

                            <p>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $item["feedback"]
                                    )
                                ) ?>

                            </p>

                        </div>


                        <!-- TANGGAL -->

                        <div class="feedback-date">

                            <?= date(
                                "d M Y, H:i",
                                strtotime(
                                    $item["updated_at"]
                                )
                            ) ?>

                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </main>

</div>


</body>

</html>