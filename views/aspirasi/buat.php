<?php

session_start();

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["role"] !== "siswa"
) {
    header("Location: ../auth/login.php");
    exit;
}

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();

$kategori = $controller->getKategori();

$message = "";
$success = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nis = $_SESSION["nis"];

    $idKategori = $_POST["id_kategori"] ?? "";
    $ket = $_POST["ket"] ?? "";

    $anonim = isset($_POST["anonim"]) ? 1 : 0;

    $foto = null;


    // ================================
    // UPLOAD FOTO
    // ================================

    if (
        isset($_FILES["foto"]) &&
        $_FILES["foto"]["error"] === UPLOAD_ERR_OK
    ) {

        $uploadDir = __DIR__ . "/../../assets/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo(
            $_FILES["foto"]["name"],
            PATHINFO_EXTENSION
        );

        $fileName =
            time() . "_" .
            $nis . "." .
            $extension;

        $target =
            $uploadDir . $fileName;

        if (
            move_uploaded_file(
                $_FILES["foto"]["tmp_name"],
                $target
            )
        ) {

            $foto = $fileName;
        }
    }


    $result = $controller->buatAspirasi(
        $nis,
        $idKategori,
        $ket,
        $foto,
        $anonim
    );


    $message = $result["message"];
    $success = $result["success"];


    if ($success) {
    header("Location: ../dashboard/histori.php?success=1");
    exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Buat Aspirasi</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>

<body>

<div class="app">

    <header class="app-header">

        <a
            href="../dashboard/siswa.php"
            class="back-button"
        >
            ←
        </a>

        <div class="app-title">
            Buat Aspirasi
        </div>

    </header>


    <main class="content">

        <div class="form-card">

            <h2>Laporkan Masalah</h2>

            <p class="form-description">
                Sampaikan masalah sarana sekolah yang kamu temukan.
            </p>


            <?php if ($message !== ""): ?>

                <div class="message
                    <?= $success ? 'success' : 'error' ?>">

                    <?= htmlspecialchars($message) ?>

                </div>

            <?php endif; ?>


            <form
                method="POST"
                enctype="multipart/form-data"
            >


                <!-- KATEGORI -->

                <div class="input-group">

                    <label>Kategori</label>

                    <select
                        name="id_kategori"
                        required
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <?php foreach ($kategori as $item): ?>

                            <option
                                value="<?= $item["id_kategori"] ?>"
                            >

                                <?= htmlspecialchars(
                                    $item["ket_kategori"]
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- DATA SISWA -->

<div class="input-group">

    <label>Kelas</label>

    <input
        type="text"
        value="<?= htmlspecialchars($_SESSION["kelas"]) ?>"
        readonly
    >

  </div>


                <!-- KETERANGAN -->

                <div class="input-group">

                    <label>Keterangan</label>

                    <textarea
                        name="ket"
                        rows="5"
                        placeholder="Jelaskan masalah yang ditemukan..."
                        required
                    ></textarea>

                </div>


                <!-- FOTO -->

                <div class="input-group">

                    <label>Foto</label>

                    <input
                        type="file"
                        name="foto"
                        accept="image/*"
                    >

                </div>


                <!-- ANONIM -->

                <div class="checkbox-group">

                    <input
                        type="checkbox"
                        name="anonim"
                        value="1"
                        id="anonim"
                    >

                    <label for="anonim">
                        Kirim sebagai anonim
                    </label>

                </div>


                <button
                    type="submit"
                    class="btn-primary"
                >
                    Kirim Aspirasi
                </button>

            </form>

        </div>

    </main>

</div>

</body>

</html>