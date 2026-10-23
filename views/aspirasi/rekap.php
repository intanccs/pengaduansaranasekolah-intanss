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

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();

$bulan = isset($_GET["bulan"])
    ? (int) $_GET["bulan"]
    : (int) date("n");

$tahun = isset($_GET["tahun"])
    ? (int) $_GET["tahun"]
    : (int) date("Y");

$tanggal = isset($_GET["tanggal"]) &&
    $_GET["tanggal"] !== ""
    ? (int) $_GET["tanggal"]
    : null;

// Validasi filter
if ($bulan < 1 || $bulan > 12) {
    $bulan = (int) date("n");
}

if ($tahun < 2000 || $tahun > 2100) {
    $tahun = (int) date("Y");
}

if (
    $tanggal !== null &&
    !checkdate($bulan, $tanggal, $tahun)
) {
    $tanggal = null;
}

$rekap = $controller->rekapPengaduan(
    $bulan,
    $tahun,
    $tanggal
);

$dataAspirasi = $controller->pengaduanPeriode(
    $bulan,
    $tahun,
    $tanggal
);

function eRekap($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        "UTF-8"
    );
}

$namaBulan = [
    1 => "Januari",
    2 => "Februari",
    3 => "Maret",
    4 => "April",
    5 => "Mei",
    6 => "Juni",
    7 => "Juli",
    8 => "Agustus",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Desember"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rekap Pengaduan</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >
</head>

<body>

<div class="app">

    <header class="app-header">
        <a
            href="../dashboard/admin.php"
            style="color:inherit;text-decoration:none;"
        >←</a>

        <div class="app-title">Rekap Pengaduan</div>
    </header>

    <main class="content">

        <h2 class="section-title">Filter Periode</h2>

        <form method="GET" class="rekap-filter">

            <div class="input-group">
                <label for="bulan">Bulan</label>

                <select id="bulan" name="bulan" required>
                    <?php foreach ($namaBulan as $nomor => $nama): ?>
                        <option
                            value="<?= $nomor ?>"
                            <?= $bulan === $nomor ? "selected" : "" ?>
                        >
                            <?= eRekap($nama) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <label for="tahun">Tahun</label>

                <input
                    type="number"
                    id="tahun"
                    name="tahun"
                    min="2000"
                    max="2100"
                    value="<?= $tahun ?>"
                    required
                >
            </div>

            <div class="input-group">
                <label for="tanggal">
                    Tanggal (opsional)
                </label>

                <select id="tanggal" name="tanggal">
                    <option value="">Semua tanggal</option>

                    <?php
                    $jumlahHari = cal_days_in_month(
                        CAL_GREGORIAN,
                        $bulan,
                        $tahun
                    );

                    for ($hari = 1; $hari <= $jumlahHari; $hari++):
                    ?>
                        <option
                            value="<?= $hari ?>"
                            <?= $tanggal === $hari ? "selected" : "" ?>
                        >
                            <?= $hari ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn-primary">
                Tampilkan Rekap
            </button>

        </form>

        <h2 class="section-title">
            Rekap <?= eRekap($namaBulan[$bulan]) ?>
            <?= $tahun ?>
            <?= $tanggal !== null
                ? " — Tanggal " . $tanggal
                : "" ?>
        </h2>

        <section class="rekap-grid">

            <div class="rekap-card">
                <span>Total Pengaduan</span>
                <strong><?= (int) ($rekap["total"] ?? 0) ?></strong>
            </div>

            <div class="rekap-card">
                <span>Menunggu</span>
                <strong><?= (int) ($rekap["menunggu"] ?? 0) ?></strong>
            </div>

            <div class="rekap-card">
                <span>Diproses</span>
                <strong><?= (int) ($rekap["diproses"] ?? 0) ?></strong>
            </div>

            <div class="rekap-card">
                <span>Selesai</span>
                <strong><?= (int) ($rekap["selesai"] ?? 0) ?></strong>
            </div>

        </section>

        <h2 class="section-title">Daftar Pengaduan</h2>

        <?php if (empty($dataAspirasi)): ?>

            <div class="empty-message">
                Tidak ada pengaduan pada periode ini.
            </div>

        <?php else: ?>

            <?php foreach ($dataAspirasi as $item): ?>

                <article class="complaint-card">

                    <h3>
                        <?= eRekap($item["ket_kategori"]) ?>
                    </h3>

                    <p>
                        <strong>ID Pengaduan:</strong>
                        <?= (int) $item["id_aspirasi"] ?>
                    </p>

                    <p>
                        <strong>Tanggal:</strong>
                        <?= eRekap(date(
                            "d-m-Y H:i",
                            strtotime($item["created_at"])
                        )) ?>
                    </p>

                    <p>
                        <strong>Pelapor:</strong>
                        <?= (int) $item["anonim"] === 1
                            ? "Anonim"
                            : eRekap($item["nama_siswa"]) ?>
                    </p>

                    <p>
                        <strong>Kelas:</strong>
                        <?= (int) $item["anonim"] === 1
                            ? "Disembunyikan"
                            : eRekap($item["kelas"]) ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?= eRekap($item["status"]) ?>
                    </p>

                    <a
                        class="detail-button"
                        href="detail.php?id=<?= (int) $item["id_aspirasi"] ?>"
                    >
                        Lihat Detail
                    </a>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>
</div>

</body>
</html>