<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");

if (
    !isset($_SESSION["login"]) ||
    $_SESSION["login"] !== true ||
    ($_SESSION["role"] ?? "") !== "admin"
) {
    http_response_code(403);

    echo json_encode([
        "success" => false,
        "message" => "Akses ditolak."
    ]);

    exit;
}

require_once __DIR__ . "/../../controllers/AspirasiController.php";

$controller = new AspirasiController();

// Inisialisasi saat pertama kali dibuka
if (isset($_GET["init"])) {
    echo json_encode([
        "success" => true,
        "latest_id" => $controller->idAspirasiTerbaru()
    ]);

    exit;
}

$lastId = filter_input(INPUT_GET, "last_id", FILTER_VALIDATE_INT);

if ($lastId === false || $lastId === null || $lastId < 0) {
    $lastId = 0;
}

$data = $controller->laporanBaru($lastId);

echo json_encode([
    "success" => true,
    "reports" => $data
]);