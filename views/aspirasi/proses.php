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
$status = "Diproses";

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

function eProses($value)
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
    <title>Pengaduan Dalam Proses</title>

    <link rel="stylesheet" href="../../assets/css/style.css">

    <style>
        .process-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .process-category,
        .process-card {
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

        .process-category h3 {
            color: #267fa6;
            margin: 10px 0;
        }

        .process-count {
            color: #657781;
            font-size: 13px;
        }

        .process-card p {
            line-height: 1.5;
            margin: 9px 0;
        }

        .process-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            background: #fff0d6;
            color: #8a5a00;
            font-size: 12px;
        }

        .process-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 9px;
            background: #388fd0;
            color: white;
            text-decoration: none;
        }

        .process-back {
            display: inline-block;
            margin-bottom: 16px;
            color: #267fa6;
            text-decoration: none;
        }

        .process-empty {
            background: white;
            border-radius: 14px;
            padding: 20px;
        }

        @media (max-width: 350px) {
            .process-grid {
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

        <div class="app-title">Dalam Proses</div>
    </header>

    <main class="content">

        <?php if (!$idKategori || $idKategori < 1): ?>

            <h2 class="section-title">Kategori Dalam Proses</h2>
            <p>Pilih kategori untuk melihat pengaduan yang sedang ditangani.</p>

            <?php if (empty($kategoriList)): ?>

                <div class="process-empty">
                    Tidak ada pengaduan dengan status Diproses.
                </div>

            <?php else: ?>

                <section class="process-grid">
                    <?php foreach ($kategoriList as $kategori): ?>

                        <a class="process-category"
                           href="proses.php?kategori=<?= (int) $kategori["id_kategori"] ?>">

                            <div style="font-size:28px;">🔧</div>

                            <h3>
                                <?= eProses($kategori["ket_kategori"]) ?>
                            </h3>

                            <div class="process-count">
                                <?= (int) $kategori["jumlah"] ?>
                                pengaduan dalam proses
                            </div>

                        </a>

                    <?php endforeach; ?>
                </section>

            <?php endif; ?>

        <?php elseif ($kategoriAktif !== null): ?>

            <a class="process-back" href="proses.php">
                ← Kembali ke kategori
            </a>

            <h2 class="section-title">
                <?= eProses($kategoriAktif["ket_kategori"]) ?>
            </h2>

            <?php if (empty($dataAspirasi)): ?>

                <div class="process-empty">
                    Tidak ada pengaduan dalam proses pada kategori ini.
                </div>

            <?php else: ?>

                <?php foreach ($dataAspirasi as $item): ?>

                    <article class="process-card">

                        <h3><?= eProses($item["ket_kategori"]) ?></h3>

                        <p>
                            <strong>ID Pengaduan:</strong>
                            <?= (int) $item["id_aspirasi"] ?>
                        </p>

                        <p>
                            <strong>Pelapor:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Anonim"
                                : eProses($item["nama_siswa"]) ?>
                        </p>

                        <p>
                            <strong>Kelas:</strong>
                            <?= (int) $item["anonim"] === 1
                                ? "Disembunyikan"
                                : eProses($item["kelas"]) ?>
                        </p>

                        <p>
                            <strong>Tanggal:</strong>
                            <?= eProses($item["created_at"]) ?>
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <span class="process-badge">Diproses</span>
                        </p>

                        <a class="process-button"
                           href="detail.php?id=<?= (int) $item["id_aspirasi"] ?>">
                            Lihat Detail
                        </a>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php else: ?>

            <div class="process-empty">
                Kategori tidak ditemukan atau tidak memiliki pengaduan dalam proses.
            </div>

            <a class="process-back" href="proses.php">
                ← Kembali
            </a>

        <?php endif; ?>

    </main>
</div>
</body>
</html>