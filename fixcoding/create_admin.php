<?php

require_once "models/Database.php";

$db = new Database();

$pdo = $db->getConnection();


$username = "admin";

$nama = "Administrator";

$password = password_hash(
    "123456",
    PASSWORD_DEFAULT
);

$role = "Staff Prasarana Sekolah";


$query = $pdo->prepare(
    "INSERT INTO admins
    (username, nama, password, role, created_at, updated_at)
    VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"
);


$query->execute([
    $username,
    $nama,
    $password,
    $role
]);


echo "Admin berhasil dibuat.";