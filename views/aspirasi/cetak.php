<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    ($_SESSION["role"] ?? "") !== "admin"
) {
    exit("Akses ditolak.");
}

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$mode = $_GET["mode"] ?? "preview";

if (!$id || $id < 1) {
    exit("ID pengaduan tidak valid.");
}

if (!in_array($mode, ["preview", "download"], true)) {
    exit("Mode tidak valid.");
}

$item = $controller->detailAdmin($id);

if (!$item) {
    exit("Data pengaduan tidak ditemukan.");
}

function eCetak($value)
{
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

// Menyiapkan foto
$fotoSrc = "";

if (!empty($item["foto"])) {
    $namaFoto = basename($item["foto"]);
    $pathFoto = __DIR__ . "/../../assets/uploads/" . $namaFoto;

    if (is_file($pathFoto)) {
        $mime = mime_content_type($pathFoto);

        $formatDiizinkan = [
            "image/jpeg",
            "image/png",
            "image/gif"
        ];

        if (in_array($mime, $formatDiizinkan, true)) {
            $isiFoto = base64_encode(file_get_contents($pathFoto));
            $fotoSrc = "data:" . $mime . ";base64," . $isiFoto;
        }
    }
}

$tanggal = date(
    "d-m-Y H:i",
    strtotime($item["created_at"])
);

$namaFile = "Laporan_Pengaduan_" . $id . ".doc";

// Isi laporan
ob_start();
?>

<h2 class="judul-laporan">
    LAPORAN PENGADUAN SARANA DAN PRASARANA
</h2>

<table class="tabel-laporan" border="1">
    <tr>
        <td class="informasi-laporan">

            <p>
                <strong>ID Pengaduan:</strong>
                <?= (int) $item["id_aspirasi"] ?>
            </p>

            <p>
                <strong>Kategori:</strong>
                <?= eCetak($item["ket_kategori"]) ?>
            </p>

            <p>
                <strong>Pelapor:</strong>
                <?= (int) $item["anonim"] === 1
                    ? "Anonim"
                    : eCetak($item["nama_siswa"]) ?>
            </p>

            <p>
                <strong>Kelas:</strong>
                <?= (int) $item["anonim"] === 1
                    ? "Disembunyikan"
                    : eCetak($item["kelas"]) ?>
            </p>

            <p>
                <strong>Tanggal:</strong>
                <?= eCetak($tanggal) ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?= eCetak($item["status"]) ?>
            </p>

            <p><strong>Keterangan:</strong></p>

            <div class="keterangan-laporan">
                <?= nl2br(eCetak($item["ket"])) ?>
            </div>

        </td>

        <td class="foto-laporan">
            <strong>Foto Pengaduan</strong>

            <?php if ($fotoSrc !== ""): ?>
                <p>
                    <img
                        src="<?= $fotoSrc ?>"
                        alt="Foto pengaduan"
                    >
                </p>
            <?php else: ?>
                <p>Tidak ada foto pengaduan.</p>
            <?php endif; ?>
        </td>
    </tr>
</table>

<?php
$isiLaporan = ob_get_clean();

// Mode unduh Word
if ($mode === "download") {
    header("Content-Type: application/msword; charset=utf-8");
    header(
        'Content-Disposition: attachment; filename="' . $namaFile . '"'
    );
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");

    echo "\xEF\xBB\xBF";
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #222;
                font-size: 11pt;
            }

            .judul-laporan {
                text-align: center;
                font-size: 16pt;
                margin-bottom: 25px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td {
                vertical-align: top;
                padding: 8px;
            }

            .informasi-laporan {
                width: 65%;
            }

            .foto-laporan {
                width: 35%;
                text-align: center;
            }

            .foto-laporan img {
                width: 100%;
                max-width: 220px;
            }

            .keterangan-laporan {
                line-height: 1.6;
            }
        </style>
    </head>
    <body>
        <?= $isiLaporan ?>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratinjau Laporan</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="cetak-preview-page">

    <div class="cetak-toolbar">
        <a
            href="cetak.php?id=<?= (int) $id ?>&mode=download"
            class="cetak-unduh"
        >
            Unduh Word
        </a>

        <button
            type="button"
            class="cetak-tombol-print"
            onclick="window.print()"
        >
            Cetak
        </button>
    </div>

    <main class="cetak-kertas">
        <?= $isiLaporan ?>
    </main>

</body>
</html>
