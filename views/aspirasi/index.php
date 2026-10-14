<?php
session_start();

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    ($_SESSION["role"] ?? "") !== "admin"
) {
    header("Location: ../auth/login.php");
    exit;
}

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();
$kategoriList = $controller->kategoriDenganJumlah();

$idKategori = filter_input(
    INPUT_GET,
    "kategori",
    FILTER_VALIDATE_INT
);

$kategoriAktif = null;
$dataAspirasi = [];

if ($idKategori && $idKategori > 0) {
    foreach ($kategoriList as $kategori) {
        if ((int) $kategori["id_kategori"] === $idKategori) {
            $kategoriAktif = $kategori;
            break;
        }
    }

    if ($kategoriAktif !== null) {
        $dataAspirasi = $controller->aspirasiPerKategori(
            $idKategori
        );
    } else {
        http_response_code(404);
    }
}

function e($value)
{
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Semua Pengaduan</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

    
</head>

<body>
<div class="app">

    <header class="app-header">
        <a href="../dashboard/admin.php"
           style="color:inherit;text-decoration:none;">←</a>

        <div class="app-title">
            <?= $kategoriAktif
                ? e($kategoriAktif["ket_kategori"])
                : "Semua Pengaduan" ?>
        </div>
    </header>

    <main class="content">

        <?php if (!$idKategori): ?>

            <h2 class="section-title">Kategori Pengaduan</h2>

            <p>Pilih kategori untuk melihat laporan siswa.</p>

            <?php if (empty($kategoriList)): ?>

                <div class="empty-message">
                    Belum ada kategori yang terdaftar.
                </div>

            <?php else: ?>

                <section class="category-grid">
                    <?php foreach ($kategoriList as $kategori): ?>

                        <a class="category-card"
                           href="index.php?kategori=<?= (int) $kategori["id_kategori"] ?>">

                            <div class="category-icon">📋</div>

                            <h3>
                                <?= e($kategori["ket_kategori"]) ?>
                            </h3>

                            <div class="category-count">
                                <?= (int) $kategori["jumlah"] ?>
                                pengaduan
                            </div>

                        </a>

                    <?php endforeach; ?>
                </section>

            <?php endif; ?>

        <?php elseif ($kategoriAktif !== null): ?>

            <a class="back-link" href="index.php">
                ← Kembali ke kategori
            </a>

            <h2 class="section-title">
                <?= e($kategoriAktif["ket_kategori"]) ?>
            </h2>

            <?php if (empty($dataAspirasi)): ?>

                <div class="empty-message">
                    Belum ada pengaduan dalam kategori ini.
                </div>

            <?php else: ?>

                <?php foreach ($dataAspirasi as $item): ?>

                    <article class="complaint-card">

                        <h3><?= e($item["ket_kategori"]) ?></h3>

                        <p>
                            <strong>ID Pengaduan:</strong>
                            <?= (int) $item["id_aspirasi"] ?>
                        </p>

                        <p>
                            <strong>Pelapor:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Anonim"
                                : e($item["nama_siswa"]) ?>
                        </p>

                        <p>
                            <strong>Kelas:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Disembunyikan"
                                : e($item["kelas"]) ?>
                        </p>

                        <p>
                            <strong>Tanggal:</strong>
                            <?= e($item["created_at"]) ?>
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <span class="status-badge">
                                <?= e($item["status"]) ?>
                            </span>
                        </p>

                        <a class="detail-button"
                           href="detail.php?id=<?= (int) $item["id_aspirasi"] ?>">
                            Lihat Detail
                        </a>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php else: ?>

            <p>Kategori tidak ditemukan.</p>

            <a class="back-link" href="index.php">
                ← Kembali ke kategori
            </a>

        <?php endif; ?>

    </main>
</div>
</body>
  </html>