<?php

session_start();

require_once __DIR__ . "/../../controllers/AuthController.php";

$auth = new AuthController();

$message = "";
$messageType = "";

$loginType = $_POST["login_type"] ?? "siswa";


if (isset($_SESSION["register_success"])) {

    $message =
        $_SESSION["register_success"];

    $messageType = "success";

    unset(
        $_SESSION["register_success"]
    );
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    // =========================
    // LOGIN SISWA
    // =========================

    if ($loginType === "siswa") {

        $nis =
            $_POST["nis"] ?? "";

        $password =
            $_POST["password"] ?? "";


        $result =
            $auth->loginSiswa(
                $nis,
                $password
            );


        $message =
            $result["message"];


        if ($result["success"]) {

            header(
                "Location: ../dashboard/siswa.php"
            );

            exit;

        } else {

            $messageType = "error";
        }
    }


    // =========================
    // LOGIN ADMIN
    // =========================

    elseif ($loginType === "admin") {

        $username =
            $_POST["username"] ?? "";

        $password =
            $_POST["password"] ?? "";


        $result =
            $auth->loginAdmin(
                $username,
                $password
            );


        $message =
            $result["message"];


        if ($result["success"]) {

            header(
                "Location: ../dashboard/admin.php"
            );

            exit;

        } else {

            $messageType = "error";
        }
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

    <title>Login</title>

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

</head>


<body>

<div class="auth-container">

    <div class="auth-box">


        <div class="auth-header">

            <div class="school-icon">
                🏫
            </div>

            <h1>
                Login
            </h1>

            <p>
                Pengaduan Sarana Sekolah
            </p>

        </div>


        <?php if ($message !== ""): ?>

            <div class="message <?= $messageType ?>">

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <!-- PILIH JENIS LOGIN -->

        <div class="login-choice">

            <button
                type="button"
                onclick="showLogin('siswa')"
                id="siswaBtn"
                class="choice-active"
            >
                Siswa
            </button>

            <button
                type="button"
                onclick="showLogin('admin')"
                id="adminBtn"
            >
                Admin
            </button>

        </div>


        <!-- LOGIN SISWA -->

        <form
            method="POST"
            id="siswaForm"
        >

            <input
                type="hidden"
                name="login_type"
                value="siswa"
            >


            <div class="input-group">

                <label>
                    NIS
                </label>

                <input
                    type="number"
                    name="nis"
                    required
                >

            </div>


            <div class="input-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-primary"
            >
                Login Siswa
            </button>


            <p class="auth-switch">

                Belum punya akun?

                <a href="register.php">
                    Register
                </a>

            </p>

        </form>


        <!-- LOGIN ADMIN -->

        <form
            method="POST"
            id="adminForm"
            style="display:none;"
        >

            <input
                type="hidden"
                name="login_type"
                value="admin"
            >


            <div class="input-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                >

            </div>


            <div class="input-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                >

            </div>


            <button
                type="submit"
                class="btn-primary"
            >
                Login Admin
            </button>

        </form>


    </div>

</div>


<script>

function showLogin(type) {

    var siswaForm =
        document.getElementById("siswaForm");

    var adminForm =
        document.getElementById("adminForm");

    var siswaBtn =
        document.getElementById("siswaBtn");

    var adminBtn =
        document.getElementById("adminBtn");


    if (type === "siswa") {

        siswaForm.style.display = "block";

        adminForm.style.display = "none";

        siswaBtn.classList.add(
            "choice-active"
        );

        adminBtn.classList.remove(
            "choice-active"
        );

    } else {

        siswaForm.style.display = "none";

        adminForm.style.display = "block";

        siswaBtn.classList.remove(
            "choice-active"
        );

        adminBtn.classList.add(
            "choice-active"
        );
    }
}

</script>

</body>

</html>