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
$status = "Menunggu";

$kategoriList = $controller->kategoriBerdasarkanStatus($status);

$idKategori = filter_input(INPUT_GET, "kategori", FILTER_VALIDATE_INT);
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
        $dataAspirasi =
            $controller->daftarBerdasarkanKategoriDanStatus(
                $idKategori,
                $status
            );
    }
}

function eMenunggu($value)
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
    <title>Pengaduan Menunggu</title>
    <link rel="stylesheet" href="../../assets/css/style.css">

    <style>
        .waiting-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .waiting-category,
        .waiting-card {
            display: block;
            padding: 18px;
            margin-bottom: 14px;
            background: white;
            border-radius: 16px;
            color: inherit;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(0,0,0,.05);
            overflow-wrap: anywhere;
        }

        .waiting-category h3 {
            color: #267fa6;
            margin: 10px 0;
        }

        .waiting-count {
            color: #657781;
            font-size: 13px;
        }

        .waiting-card p {
            line-height: 1.5;
            margin: 9px 0;
        }

        .waiting-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            background: #e8f3fa;
            color: #176b91;
            font-size: 12px;
        }

        .waiting-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 9px;
            background: #388fd0;
            color: white;
            text-decoration: none;
        }

        .waiting-back {
            display: inline-block;
            margin-bottom: 16px;
            color: #267fa6;
            text-decoration: none;
        }

        .waiting-empty {
            background: white;
            border-radius: 14px;
            padding: 20px;
        }

        @media (max-width: 350px) {
            .waiting-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="app">
    <header class="app-header">
        <a href="../dashboard/admin.php"
           style="color:inherit;text-decoration:none;">←</a>
        <div class="app-title">Pengaduan Menunggu</div>
    </header>

    <main class="content">

        <?php if (!$idKategori || $idKategori < 1): ?>

            <h2 class="section-title">Kategori Menunggu</h2>
            <p>Pilih kategori untuk melihat pengaduan yang belum diproses.</p>

            <?php if (empty($kategoriList)): ?>

                <div class="waiting-empty">
                    Tidak ada pengaduan dengan status Menunggu.
                </div>

            <?php else: ?>

                <section class="waiting-grid">
                    <?php foreach ($kategoriList as $kategori): ?>
                        <a class="waiting-category"
                           href="menunggu.php?kategori=<?= (int) $kategori["id_kategori"] ?>">

                            <div style="font-size:28px;">🕒</div>

                            <h3><?= eMenunggu($kategori["ket_kategori"]) ?></h3>

                            <div class="waiting-count">
                                <?= (int) $kategori["jumlah"] ?> pengaduan menunggu
                            </div>
                        </a>
                    <?php endforeach; ?>
                </section>

            <?php endif; ?>

        <?php elseif ($kategoriAktif !== null): ?>

            <a class="waiting-back" href="menunggu.php">
                ← Kembali ke kategori
            </a>

            <h2 class="section-title">
                <?= eMenunggu($kategoriAktif["ket_kategori"]) ?>
            </h2>

            <?php if (empty($dataAspirasi)): ?>

                <div class="waiting-empty">
                    Tidak ada pengaduan menunggu dalam kategori ini.
                </div>

            <?php else: ?>

                <?php foreach ($dataAspirasi as $item): ?>
                    <article class="waiting-card">
                        <h3><?= eMenunggu($item["ket_kategori"]) ?></h3>

                        <p><strong>ID Pengaduan:</strong>
                            <?= (int) $item["id_aspirasi"] ?></p>

                        <p><strong>Pelapor:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Anonim"
                                : eMenunggu($item["nama_siswa"]) ?></p>

                        <p><strong>Kelas:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Disembunyikan"
                                : eMenunggu($item["kelas"]) ?></p>

                        <p><strong>Tanggal:</strong>
                            <?= eMenunggu($item["created_at"]) ?></p>

                        <p><strong>Status:</strong>
                            <span class="waiting-badge">Menunggu</span>
                        </p>

                        <a class="waiting-button"
                           href="detail.php?id=<?= (int) $item["id_aspirasi"] ?>">
                            Lihat Detail
                        </a>
                    </article>
                <?php endforeach; ?>

            <?php endif; ?>

        <?php else: ?>

            <div class="waiting-empty">
                Kategori tidak ditemukan atau tidak memiliki pengaduan menunggu.
            </div>

            <a class="waiting-back" href="menunggu.php">
                ← Kembali
            </a>

        <?php endif; ?>

    </main>
</div>
</body>
</html>