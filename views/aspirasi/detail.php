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

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID pengaduan tidak valid.");
}

$item = $controller->detailAdmin($id);

if (!$item) {
    http_response_code(404);
    exit("Pengaduan tidak ditemukan.");
}

function e($value)
{
    return htmlspecialchars(
        (string) ($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}

$foto = $item["foto"] ?? "";
$fotoUrl = "";

if ($foto !== "") {
    $namaFile = basename($foto);
    $pathFoto = __DIR__ . "/../../assets/uploads/" . $namaFile;

    if (is_file($pathFoto)) {
        $fotoUrl = "../../assets/uploads/" . rawurlencode($namaFile);
    }
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = $_POST["status"] ?? "";
    $feedback = trim($_POST["feedback"] ?? "");

    $result = $controller->updateStatusFeedback(
        $id,
        $status,
        $feedback,
        $_SESSION["admin_id"]
    );

    if ($result["success"]) {
        header("Location: detail.php?id=" . $id . "&updated=1");
        exit;
    }

    $error = $result["message"];
}

$updated = isset($_GET["updated"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan</title>
    <link rel="stylesheet" href="../../assets/css/style.css">

    <style>
        .detail-card {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 20px;
            overflow-wrap: anywhere;
        }

        .detail-card p {
            margin: 12px 0;
            line-height: 1.6;
        }

        .detail-photo {
            width: 100%;
            max-width: 450px;
            border-radius: 12px;
            margin-top: 10px;
        }

        .detail-card label {
            display: block;
            margin: 15px 0 7px;
            font-weight: bold;
        }

        .detail-card select,
        .detail-card textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd8df;
            border-radius: 10px;
            font: inherit;
            box-sizing: border-box;
        }

        .detail-card textarea {
            min-height: 110px;
            resize: vertical;
        }

        .notice {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #e4f6e8;
            color: #236b35;
        }

        .error {
            background: #ffe8e8;
            color: #9b2222;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 16px;
            color: #247eaa;
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="app">
    <header class="app-header">
        <a href="index.php"
           style="color:inherit;text-decoration:none;">←</a>
        <div class="app-title">Detail Pengaduan</div>
    </header>

    <main class="content">
        <a href="index.php" class="back-link">
            ← Kembali ke daftar pengaduan
        </a>

        <?php if ($updated): ?>
            <div class="notice">Pengaduan berhasil diperbarui.</div>
        <?php endif; ?>

        <?php if ($error !== ""): ?>
            <div class="notice error"><?= e($error) ?></div>
        <?php endif; ?>

        <section class="detail-card">
            <h2><?= e($item["ket_kategori"]) ?></h2>

            <p><strong>ID Pengaduan:</strong>
                <?= e($item["id_aspirasi"]) ?></p>

            <p><strong>Pelapor:</strong>
                <?= (int) $item["anonim"] === 1
                    ? "Anonim"
                    : e($item["nama_siswa"]) ?></p>

            <p><strong>Kelas:</strong>
                <?= (int) $item["anonim"] === 1
                    ? "Disembunyikan"
                    : e($item["kelas"]) ?></p>

            <p><strong>Tanggal:</strong>
                <?= e($item["created_at"]) ?></p>

            <p><strong>Keterangan:</strong></p>
            <p><?= nl2br(e($item["ket"])) ?></p>

            <?php if ($fotoUrl !== ""): ?>
                <p><strong>Foto Pengaduan:</strong></p>
                <img class="detail-photo"
                     src="<?= e($fotoUrl) ?>"
                     alt="Foto pengaduan">
            <?php else: ?>
                <p><strong>Foto:</strong> Tidak tersedia.</p>
            <?php endif; ?>

            <p><strong>Status saat ini:</strong>
                <?= e($item["status"]) ?></p>

            <p><strong>Feedback sebelumnya:</strong><br>
                <?= $item["feedback"] !== null &&
                    trim($item["feedback"]) !== ""
                    ? nl2br(e($item["feedback"]))
                    : "Belum ada feedback." ?></p>
        </section>

        <section class="detail-card">
            <h2>Perbarui Pengaduan</h2>

            <form method="POST">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <?php
                    $daftarStatus = [
                        "Menunggu",
                        "Diproses",
                        "Selesai"
                    ];
                    foreach ($daftarStatus as $pilihan):
                    ?>
                        <option value="<?= e($pilihan) ?>"
                            <?= $item["status"] === $pilihan
                                ? "selected"
                                : "" ?>>
                            <?= e($pilihan) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="feedback">Feedback untuk Siswa</label>
                <textarea name="feedback" id="feedback"
                    placeholder="Tulis tanggapan atau tindak lanjut pengaduan..."><?= e($item["feedback"]) ?></textarea>

                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </section>
    </main>
</div>
</body>
</html>